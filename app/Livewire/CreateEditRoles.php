<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Validate;

class CreateEditRoles extends Component
{
    #[validate('required')]
    public $roleName;
    public $permissions;
    public $permissionsSelected = [];

    public $edit = false;

    public function mount($id = NULL) {
        if($id != NULL) {
            $this->edit == true;
        }

        if($this->edit == true) {

        } else {
            $this->permissions = Permission::all();
        }

    }

    public function save() {
        dd($this->permissionsSelected);
        // $this->validate();
    }

    public function render()
    {
        return view('livewire.create-edit-roles');
    }
}
