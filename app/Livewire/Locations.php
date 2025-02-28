<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Location;
use App\Models\User;

class Locations extends Component
{
    #[validate('required|min:3')]
    public $name;
    #[validate('required|min:3')]
    public $city;
    #[validate('required|min:3')]
    public $country;
    #[validate('required|min:1')]
    public $user_ids;
    public $users;
    public $edit = false;
    public $editLocation;

    public $is_default;

    public function store() {
        $validated = $this->validate();
        Location::where('is_default', true)->exists() ? $this->is_default = false : $this->is_default = true;
        if($this->edit == true) {
            Location::where('id', $this->editLocation->id)->update([
                'name' => $validated['name'],
                'city' => $validated['city'],
                'country' => $validated['country'],
                'users' => $this->user_ids
            ]);
            session()->flash('message', 'Location has been updated successfully');
        } else {
            Location::create([
                'name' => $validated['name'],
                'city' => $validated['city'],
                'country' => $validated['country'],
                'is_default' => $this->is_default,
                'users' => $this->user_ids
            ]);

            session()->flash('message', 'Location(s) has been created successfully');
        }


        return redirect()->route('locations.index');
    }


    public function mount(Location $location, User $users, $id=NULL)
    {
        if($id) {
            $this->edit = true;
            $this->editLocation = Location::where('id', $id)->first();
            $this->name = $this->editLocation->name;
            $this->city = $this->editLocation->city;
            $this->country = $this->editLocation->country;
            $this->user_ids = $this->editLocation->users;
        }

        $this->users = User::all();

    }


    public function render()
    {

        return view('livewire.locations');
    }
}
