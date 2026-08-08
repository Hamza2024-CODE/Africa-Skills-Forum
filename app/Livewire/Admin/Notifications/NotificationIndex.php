<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\WsapNotification;
use App\Services\Notifications\NotificationService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class NotificationIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterType   = '';
    public string $filterStatus = '';
    public string $flashMessage = '';

    public function dispatchNow(int $id, NotificationService $service): void
    {
        $notification = WsapNotification::findOrFail($id);
        $res = $service->dispatchNotification($notification);
        $this->flashMessage = "تم إرسال التنبيه بنجاح إلى {$res['recipients_count']} مستخدماً معتمداً.";
    }

    public function cancelNotification(int $id, NotificationService $service): void
    {
        $notification = WsapNotification::findOrFail($id);
        $service->cancelNotification($notification);
        $this->flashMessage = "تم إلغاء الإشعار المجدول.";
    }

    public function deleteNotification(int $id): void
    {
        WsapNotification::findOrFail($id)->delete();
        $this->flashMessage = "تم حذف الإشعار.";
    }

    public function duplicateNotification(int $id): void
    {
        $n = WsapNotification::with('targets')->findOrFail($id);
        $new = $n->replicate(['uuid', 'status', 'dispatched_at', 'created_at', 'updated_at']);
        $new->status = 'DRAFT';
        $new->created_by = auth()->id();
        $new->save();

        foreach ($n->targets as $t) {
            $new->targets()->create([
                'target_type' => $t->target_type,
                'target_id'   => $t->target_id,
            ]);
        }

        $this->flashMessage = "تم تكرار الإشعار بنجاح إلى مسودة جديدة.";
    }

    public function render(NotificationService $service)
    {
        $query = WsapNotification::with(['creator', 'targets', 'userNotifications'])
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where('title_ar', 'like', $s)
                  ->orWhere('body_ar', 'like', $s);
            })
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));

        $notifications = $query->orderByDesc('created_at')->paginate(10);

        // Calculate delivery stats for paginated items
        $analyticsMap = [];
        foreach ($notifications as $n) {
            $analyticsMap[$n->id] = $service->getDeliveryAnalytics($n);
        }

        return view('livewire.admin.notifications.index', [
            'notifications' => $notifications,
            'analyticsMap'  => $analyticsMap,
            'totalCount'    => WsapNotification::count(),
            'sentCount'     => WsapNotification::where('status', 'SENT')->count(),
            'scheduledCount'=> WsapNotification::where('status', 'SCHEDULED')->count(),
            'urgentCount'   => WsapNotification::where('priority', 'URGENT')->count(),
        ]);
    }
}
