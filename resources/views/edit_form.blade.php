<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('Forms') }}
        </h2>
    </x-slot>
@if($type_id==1)
 @livewire('forms.edit.edit-form-questions',['id'=>$id,'lastLocal'=>$lastLocal])
@elseif($type_id==2)
@livewire('forms.edit.edit-form-media',['id'=>$id,'lastLocal'=>$lastLocal])
@else
@endif

  <!-- Main modal -->



</x-app-layout>
