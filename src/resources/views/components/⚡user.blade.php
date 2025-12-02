<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public ?User $user;
};
?>

<div>
    {{ $user }}
</div>