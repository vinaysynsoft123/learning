@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
              
                        <h5 class="mb-0">{{ isset($term) ? 'Edit Terms & Conditions' : 'Add Terms & Conditions' }}</h5>
                    </div>
                
                        <form action="{{ isset($term) ? route('terms-conditions.update', $term) : route('terms-conditions.store') }}"
                            method="POST">
                            @csrf
                            @isset($term)
                                @method('PUT')
                            @endisset

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Destination</label>
                                    <select name="destination_id" class="form-control">
                                        <option value="">All Destinations</option>
                                        @foreach ($destinations as $dest)
                                            <option value="{{ $dest->id }}" @selected(old('destination_id', $term->destination_id ?? '') == $dest->id)>
                                                {{ $dest->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('destination_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" @selected(old('status', $term->status ?? 1) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $term->status ?? 1) == 0)>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Terms & Conditions</label>
                                <textarea name="terms_conditions" class="form-control" rows="8">{{ old('terms_conditions', $term->terms_conditions ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Privacy Policy</label>
                                <textarea name="privacy_policy" class="form-control" rows="8">{{ old('privacy_policy', $term->privacy_policy ?? '') }}</textarea>
                            </div>

                            <div class="border-top pt-3 d-flex justify-content-between">                               
                                <button type="submit" class="btn btn-success px-4">Save </button>
                            </div>
                        </form>
                    </div>
                </div>
         
@endsection
