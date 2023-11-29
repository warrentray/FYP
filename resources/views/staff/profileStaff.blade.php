<title>Profile</title>
@extends('layouts.staff')

@section('content')

<div class="container bg-white text-dark ">
    <div class="row ">
        <!-- Edit Your Personal Setting -->
        <div class="col-xxl-8 mb-5 mb-xxl-0">
            <div class="  px-4 py-5 rounded">
                <div id="first" class="border p-4 text-dark">
                    <div class="row text-dark ">
                        <div class="col-md-12 text-left">
                            <h2 class="mb-4 mt-0">Personal Detail</h2>
                        </div>

                        <div class="col-md-6    ">
                            <label class="form-label  ">Name </label>
                            <h4 class="border p-1 mb-2"> {{ $user['name'] }} </h4>

                        </div>
                        <!-- Last name -->
                        <div class="col-md-6  ">
                            <label class="form-label">Station Name</label>
                            <h4 class="border p-1 mb-2 ">{{ $stationName }}</h4>
                        </div>
                        <!-- Phone number -->
                        <div class="col-md-6  ">
                            <label class="form-label">Email Address *</label>
                            <h4 class="border p-1 mb-2 ">{{$user['email']}}</h4>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth </label>
                            <?php
                                // Extract the first two digits from the identity card
                                $firstTwoDigits = substr($user['identityCard'], 0, 2);
                        
                                // Determine the century prefix based on the extracted digits
                                $centuryPrefix = ($firstTwoDigits >= 00 && $firstTwoDigits <= 99) ? '20' : '19';
                        
                                // Extract the birthYear, birthMonth, and birthDay from the identity card
                                $birthYear = $centuryPrefix . substr($user['identityCard'], 0, 2);
                                $birthMonth = substr($user['identityCard'], 2, 2);
                                $birthDay = substr($user['identityCard'], 4, 2);
                        
                                // Form the date of birth in the format dd-mm-yyyy
                                $dateOfBirth = $birthDay . '-' . $birthMonth . '-' . $birthYear;
                            ?>
                            <h4 class="border p-1 mb-2 ">{{ $dateOfBirth }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection