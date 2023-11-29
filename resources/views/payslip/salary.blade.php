<title>Salary employee</title>

<!-- resources/views/bonus/form.blade.php -->

@extends('layouts.master')

@section('content')
@include('sweetalert::alert')

<div class="container-fluid text-dark">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Salary employee</b></h6>
        </div>
        <div class="card-body">
            <div class="row mt-6">
                <div class="row mt-2 ml-2 mb-4">
                    <a href="{{ route('manageStaff') }}">
                        <button class="btn btn-warning btn-circle btn-xl"
                            style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                            <span><i class="fa fa-arrow-left"></i></span>
                        </button>
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('salary', ['id' => $user->id]) }}">
                @csrf
                @method('put')
                <div class="form-group row">
                    <label for="stationName" class="col-sm-3 col-form-label">Station</label>
                    <div class="form-group col-md-9">
                        <select class="form-control" name="stationName" id="stationName">
                            <option value="{{ $user->station_id }}">{{ $user->station->name }}</option>
                        </select>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="staff_id" class="col-sm-3 col-form-label">Staff Name: </label>
                    <div class="form-group col-md-9">
                        <select class="form-control" name="staff_id" id="staff_id">
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        </select>
                    </div>

                </div>

                <div class="form-group row">
                    <label for="basic_salary" class="col-sm-3 col-form-label">Basic Salary (RM): </label>
                    <div class="form-group col-md-9">
                        <input type="text" name="basic_salary" class="form-control" id="basic_salary"
                            value="{{$user->salary->basic_salary}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bonus_type" class="col-sm-3 col-form-label">Bonus Type: </label>
                    <div class="form-group col-md-9">
                        <input type="hidden" name="bonusType">
                        <select class="form-control @error('bonus_type') is-invalid @enderror" name="bonus_type"
                            id="bonus_type">
                            <option value="  {{$user->salary_id}}"> {{$user->salary->bonus_type}}</option>

                            @foreach($bonusTypes as $bonusType)

                            <option value=" {{ $bonusType }}">{{ $bonusType }}</option>
                            @endforeach
                            @error('bonus_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bonus_amount" class="col-sm-3 col-form-label">Bonus Amount (RM): </label>
                    <div class="form-group col-md-9">
                        <input type="text" name="bonus_amount" class="form-control" id="bonus_amount"
                            value="{{$user->salary->bonus_amount}}">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                    <button type="submit" class="btn btn-warning">Confirm</button>
                </div>
            </form>
        </div>
        @endsection