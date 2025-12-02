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

    // EDIÇÃO INLINE
    public ?int $editingId = null;
    public string $editingNome = '';
    public string $editingEmail = '';

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

    public function startEdit(int $userId)
    {
        $user = App\Models\User::findOrFail($userId);

        $this->editingId = $user->id;
        $this->editingNome = $user->name;
        $this->editingEmail = $user->email;
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'editingNome', 'editingEmail']);
    }

    public function saveEdit()
    {
        $this->validate([
            'editingNome' => 'required|min:3',
            'editingEmail' => 'required|email',
        ]);

        App\Models\User::whereKey($this->editingId)->update([
            'name' => $this->editingNome,
            'email' => $this->editingEmail,
        ]);

        $this->cancelEdit();
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
        @foreach ($this->getAllUsers() as $user)
            @if ($editingId === $user->id)
                {{-- Modo edição --}}
                <input wire:model.defer="editingNome" class="border px-1">
                <input wire:model.defer="editingEmail" class="border px-1">

                <button wire:click="saveEdit">save</button>
                <button wire:click="cancelEdit">canc</button>
                <br>
            @else
                {{-- Modo visualização --}}
                {{ $user->id }} -
                <a href="{{ route('user', $user) }}" wire:navigate>
                    {{ $user->name }}
                </a>
                - {{ $user->email }} -

                <a href="#" wire:click.prevent="startEdit({{ $user->id }})">upd</a>
                <a href="#" wire:click.prevent="del({{ $user->id }})">del</a><br>
            @endif
        @endforeach
        {{ $this->getAllUsers()->links() }}
    </div>
</div>