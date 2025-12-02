<?php

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    use WithPagination;

    #[Validate('required|min:3')]
    public string $nome = '';

    #[Validate('required|email|min:3|max:60')]
    public string $email = '';

    #[Validate('required|min:3|max:60')]
    public string $senha = '';

    function getAllUsers()
    {
        return User::paginate(15);
    }

    function del(User $user) {
        $user->delete();
    }

    function add() {
        $dados = $this->validate();
        $dados['name']=$dados['nome'];
        $dados['password']=Hash::make($dados['senha']);
        $user = App\Models\User::create($dados);
    }
};
?>

<div>
    Adicionar usuário: {{ $nome }} - {{ $email }}<br>
    <form wire:submit="add">
        Nome: <input wire:model.live="nome"/>@error('nome') {{ $message }} @enderror<br>
        E-mail: <input wire:model.live="email"/>@error('email') {{ $message }} @enderror<br>
        Senha: <input wire:model.live="senha"/><br><br>
        <button>Enviar</button>
    </form>
    <br><br>

    <div>
        @foreach($this->getAllUsers() as $user)
            {{ $user->id }} -
            <a href="{{ route('user', $user) }}" wire:navigate>{{ $user->name }}</a> 
            <a href="#" wire:click.prevent="del({{$user}})">del</a>
            <br>
        @endforeach
        {{ $this->getAllUsers()->links() }}
    </div>
</div>