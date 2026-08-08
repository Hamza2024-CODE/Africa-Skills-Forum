<?php

namespace App\Livewire\Country;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Country;
use App\Models\DelegationArrival;
use Illuminate\Support\Facades\Storage;

#[Layout('components.dashboard.app-shell')]
class DelegationArrivals extends Component
{
    use WithFileUploads;

    public $arrival_date;
    public $arrival_time;
    public $flight_number;
    public $airline_name;
    public $arrival_airport = 'مطار الهواري بومدين الدولي - الجزائر العاصمة';
    public $passenger_count = 1;
    public $notes;
    public $flight_ticket_file;

    public function mount()
    {
        $this->arrival_date = date('Y-m-d', strtotime('+10 days'));
        $this->arrival_time = '16:45';
        $this->flight_number = 'AH-2004';
        $this->airline_name = 'Air Algérie / الخطوط الجوية الجزائرية';
    }

    public function submitArrivalInfo()
    {
        $this->validate([
            'arrival_date' => 'required|date',
            'arrival_time' => 'required',
            'flight_number' => 'required|string|max:50',
            'airline_name' => 'required|string|max:100',
            'flight_ticket_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $filePath = null;
        $fileName = 'Flight_Ticket.pdf';
        $ticketType = 'pdf';

        if ($this->flight_ticket_file) {
            $fileName = $this->flight_ticket_file->getClientOriginalName();
            $ext = strtolower($this->flight_ticket_file->getClientOriginalExtension());
            $ticketType = in_array($ext, ['jpg', 'jpeg', 'png']) ? 'image' : 'pdf';
            $filePath = $this->flight_ticket_file->store('flight_tickets', 'public');
        }

        $user = auth()->user();
        $countryId = $user?->country_id ?? Country::first()?->id;

        DelegationArrival::create([
            'country_id' => $countryId,
            'arrival_date' => $this->arrival_date,
            'arrival_time' => $this->arrival_time,
            'flight_number' => $this->flight_number,
            'airline_name' => $this->airline_name,
            'arrival_airport' => $this->arrival_airport,
            'passenger_count' => $this->passenger_count,
            'notes' => $this->notes,
            'ticket_path' => $filePath ? Storage::url($filePath) : null,
            'ticket_filename' => $fileName,
            'ticket_type' => $ticketType,
            'status' => 'PENDING',
            'shuttle_assigned' => 'جاري تخصيص حافلة الاستقبال...',
        ]);

        $msg = app()->getLocale() === 'fr' 
            ? 'Les détails de l\'arrivée et le billet ont été enregistrés avec succès.' 
            : (app()->getLocale() === 'en' ? 'Arrival details and flight ticket submitted successfully.' : 'تم تسديد وتأكيد بيانات وصول الوفد وتذكرة الطيران بنجاح في قاعدة البيانات!');

        session()->flash('message', $msg);
        $this->reset(['flight_ticket_file', 'notes']);
    }

    public function render()
    {
        $user = auth()->user();
        $country = $user?->country ?? Country::first();

        $uploaded_tickets = DelegationArrival::with('country')
            ->where('country_id', $country?->id)
            ->latest()
            ->get();

        return view('livewire.country.delegation-arrivals', [
            'country' => $country,
            'uploaded_tickets' => $uploaded_tickets
        ]);
    }
}
