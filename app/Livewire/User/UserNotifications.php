<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\UserNotification;
use App\Models\WsapNotification;
use App\Services\Notifications\NotificationActionResolver;
use App\Services\Notifications\NotificationTargetResolver;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class UserNotifications extends Component
{
    use WithPagination;

    public string $filter = 'all'; // all, unread, read

    public function mount()
    {
        $this->syncUserNotifications();
    }

    public function syncUserNotifications(): void
    {
        $userId = (int) Auth::id();
        if (!$userId) return;

        $sentNotifications = WsapNotification::where('status', 'SENT')->get();
        $resolver = new NotificationTargetResolver();

        foreach ($sentNotifications as $notif) {
            $alreadyDelivered = UserNotification::where('notification_id', $notif->id)
                ->where('user_id', $userId)
                ->exists();

            if (!$alreadyDelivered) {
                $targetUserIds = $resolver->resolveUserIds($notif->targets);
                if (in_array($userId, $targetUserIds) || empty($targetUserIds)) {
                    UserNotification::create([
                        'notification_id' => $notif->id,
                        'user_id'         => $userId,
                        'channel'         => 'IN_APP',
                        'status'          => 'DELIVERED',
                        'delivered_at'    => $notif->dispatched_at ?? now(),
                    ]);
                }
            }
        }
    }

    public function markAllRead(): void
    {
        $userId = (int) Auth::id();
        UserNotification::where('user_id', $userId)
            ->whereIn('status', ['PENDING', 'DELIVERED'])
            ->update([
                'status'  => 'READ',
                'read_at' => now(),
            ]);
    }

    public function openNotification(int $id)
    {
        $userId = (int) Auth::id();
        $un = UserNotification::with('notification')
            ->where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $un->markAsClicked();

        $url = NotificationActionResolver::resolveUrl(
            $un->notification?->action_type,
            $un->notification?->action_id
        );

        return redirect()->to($url);
    }

    public function render()
    {
        $this->syncUserNotifications();

        $userId = (int) Auth::id();
        $query = UserNotification::with('notification')
            ->where('user_id', $userId)
            ->when($this->filter === 'unread', fn($q) => $q->whereIn('status', ['PENDING', 'DELIVERED']))
            ->when($this->filter === 'read', fn($q) => $q->whereIn('status', ['READ', 'CLICKED']));

        $userNotifications = $query->orderByDesc('created_at')->paginate(12);

        $unreadCount = UserNotification::where('user_id', $userId)
            ->whereIn('status', ['PENDING', 'DELIVERED'])
            ->count();

        return view('livewire.user.user-notifications', [
            'userNotifications' => $userNotifications,
            'unreadCount'       => $unreadCount,
        ]);
    }
}
