<!DOCTYPE html>
<html>
<head>
    <title>New Job Available</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>We wanted to let you know that {{ $job->gig->user->name }} has booked you for the following gig.</p>

    <h2>{{ $job->gig->event_type }}</h2>

    <h3>Details</h3>

    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($job->instruments)) }}</p>

    <p><strong>Date and Time:</strong> {{ date_format($job->gig->start_time, 'D, m/d/y g:i a').$job->gig->getEndTime($job->gig) }}</p>

    <p><strong>Location:</strong> {{ $job->gig->street_address.', '. $job->gig->city.', '.$job->gig->state.' '.$job->gig->zip_code }}</p>

    <p><strong>Payment:</strong> {{ '$'.$job->payment }}</p>

    @if($job->gig->description)
        <p><strong>Description:</strong> {{ $job->gig->description }}</p>
    @endif
    @if($job->gig->extra_details)
        <p><strong>extra_details:</strong> {{ $job->gig->extra_details }}</p>
    @endif

    <h3>Host</h3>

    <p><strong>Name:</strong> {{ $job->gig->user->name }}</p>

    <p><strong>Email:</strong> {{ $job->gig->user->email }}</p>

    <p><strong>Phone Number: </strong>{{ $job->gig->user->phone_number }}</p>

    <p>Please add this gig to your calendar and you will receive a reminder email two days before the event</p>

    <p>Thank you for using our platform!</p>
</body>
</html>