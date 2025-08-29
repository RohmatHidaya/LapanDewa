<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Lists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-header py-3 flex justify-between items-center">
                        <div>
                        <x-primary-button>
                            <a href="" class="btn " 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'create-user')">
                                <span class="text">Add User</span>
                            </a>
                        </x-primary-button>
                        </div>
                        @include('users.partials.create-user-form')
                        
                        <div>
                        <x-search-form 
                            :action="route('user')"
                            :autocomplete="true"
                            :endpoint="route('user.autocomplete')"
                            placeholder="Cari"
                        />
                        </div>
                    </div>
                    <x-status-notif type="success" :message="session('status')" />
                    <x-status-notif type="error" :message="session('destroy')" />
                    <x-tables>
                        <x-slot name="thead">
                            <th>Nama</th>
                            <th>Email</th>
                            <th>role</th>
                            <th>Action</th>
                        </x-slot>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <x-delete-button :action="route('users.destroy', $user->id)" message="Yakin Hapus User ini?" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </x-tables>                                       
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
