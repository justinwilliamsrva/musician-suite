<!DOCTYPE html>
<html>
<head>
    <title>Gig Has Unfilled Jobs</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>Your {{ $gig->event_type }} has {{ $gig->numberOfUnfilledJobs() }} unfilled jobs and is less than a week from the start date.</p>

    <br/>

    <h3><u>Gig Details</u></h3>
    <p><strong>Event:</strong> <a href="{{ route('gigs.edit', $gig->id) }}"> {{ $gig->event_type }}</a></p>
    <p><strong>Date and Time:</strong> {{ date_format($gig->start_time, 'D, m/d/y g:i a').$gig->getEndTime() }}</p>
    <p><strong>Location:</strong> {{ $gig->street_address.', '. $gig->city.', '.$gig->state.' '.$gig->zip_code }}</p>
    <p><strong>Instrument(s):</strong> {{ $gig->getAllInstruments() }}</p>
    <p><strong>Payment:</strong> {{ $gig->getPaymentRange() }}</p>
    @if($gig->description)
        <p><strong>Description:</strong> {{ $gig->description }}</p>
    @endif

    <br/>

    <p>Thank you for using Classical Connection RVA!</p>
</body>
</html>