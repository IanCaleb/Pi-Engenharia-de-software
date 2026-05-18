@extends('layouts.app')

@section('content')

<div
    x-data="{ openCreateModal: false }"
    class="max-w-7xl mx-auto p-6"
>

<div class="flex items-center justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Movement Management
    </h1>

    <button
        @click="openCreateModal = true"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
    >
        New Movement
    </button>

</div>

@if(session('success'))

    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">

        {{ session('success') }}

    </div>

@endif