<!DOCTYPE html>
<html>
<head>
    <title>Job Reminder</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>Here is your reminder for the {{ $job->gig->event_type }} on {{ date_format($job->gig->start_time, 'D, m/d/y g:i a') }}</p>

    <h3><u>Gig Details</u></h3>

    <p><strong>Event:</strong> <a href="{{ route('gigs.show', $job->gig->id) }}"> {{ $job->gig->event_type }}</a></p>

    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($job->instruments)) }}</p>

    <p><strong>Date and Time:</strong> {{ date_format($job->gig->start_time, 'D, m/d/y g:i a').$job->gig->getEndTime() }}</p>

    <p><strong>Location:</strong> {{ $job->gig->street_address.', '. $job->gig->city.', '.$job->gig->state.' '.$job->gig->zip_code }}</p>

    <p><strong>Payment:</strong> {{ '$'.$job->payment }}</p>

    @if($job->gig->description)
        <p><strong>Description:</strong> {{ $job->gig->description }}</p>
    @endif
    @if($job->extra_info)
        <p><strong>Extra info:</strong> {{ $job->extra_info }}</p>
    @endif

    <br/>

    <h3><u>Host</u></h3>

    <p><strong>Name:</strong> {{ $job->gig->user->name }}</p>

    <p><strong>Email:</strong> <a href="mailto:{{ $job->gig->user->email }}">{{ $job->gig->user->email }}</a></p>

    @if ($job->gig->user->phone_number)
        <p><strong>Phone Number: </strong><a href="tel:{{ $job->gig->user->phone_number }}">{{ $job->gig->user->phone_number }}</a></p>
    @endif
    <br/>

    <p>Thank you for using <a href="{{ route('dashboard') }}">Classical Connection RVA!</a></p>
</body>
</html>