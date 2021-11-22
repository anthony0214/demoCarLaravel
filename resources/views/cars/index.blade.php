@extends('layouts.app')

@section('content')
    <div class="m-auto w-4/5 py-24">
        <div class="text-center">
            <h1 class="text-5xl uppercase bold">
                Cars
            </h1>
        </div>

        <div class="pt-10">
            <a href="{{ route('cars.create') }}"
            class="border-b-2 pb-2 border-dotted italic text-gray-500">
                Create Cars &rarr;
            </a>
        </div>
        
        <div class="w-5/6 py-10">
            @forelse ( $cars as $car )
            <div class="m-auto">
                <div class="float-right">
                    <a href="/cars/{{ $car->id }}/edit"
                        class="border-b-2 pb-2 border-dotted italic text-green-500">
                        Edit &rarr;
                    </a>
                    <form action="/cars/{{ $car->id }}" method="POST" class="pt-3">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="border-b-2 pb-2 border-dotted italic text-red-500">
                            Delete &rarr;
                        </button>
                    </form>
                </div>
                @if (!empty($car->myimage_path))
                    <img 
                    class="h-24 shadow-xl"
                    src="{{ asset('images/' . $car->myimage_path) }}" alt="">
                @endif
                
                <span class="uppercase text-blue-500 font-bold text-xs italic">
                    Founded: {{ $car->founded }}
                </span>
                <h2 class="text-gray-700 text-5xl">
                    {{ $car->name }}
                </h2>
                <p class="text-lg text-gray-700 py-6">
                    {{ $car->description }}
                </p>
                <hr class="mt-4 mb-8">
            </div>
            @empty
            <div class="m-auto">
                <h2 class="text-gray-700 text-5xl">
                    No Cars Found!
                </h2>
            </div>
            @endforelse
        </div>
    </div>
@endsection