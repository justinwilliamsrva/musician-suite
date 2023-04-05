<!DOCTYPE html>
<html>
<head>
    <title>New Job Available</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>{{ $job->gig->user->name }} has booked you for the following gig.</p>

    <br/>

    <h3><u>Gig Details</u></h3>

    <p><strong>Event:</strong> <a href="{{ route('gigs.show', $job->gig->id) }}"> {{ $job->gig->event_type }}</a></p>

    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($job->instruments)) }}</p>

    <p><strong>Date and Time:</strong> {{ date_format($job->gig->start_time, 'D, m/d/y g:i a').$job->gig->getEndTime($job->gig) }}</p>

    <p><strong>Location:</strong> {{ $job->gig->street_address.', '. $job->gig->city.', '.$job->gig->state.' '.$job->gig->zip_code }}</p>

    <p><strong>Payment:</strong> {{ '$'.$job->payment }}</p>

    @if($job->gig->description)
        <p><strong>Description:</strong> {{ $job->gig->description }}</p>
    @endif
    @if($job->extra_info)
        <p><strong>Extra Details:</strong> {{ $job->extra_info }}</p>
    @endif

    <br/>

    <h3><u>Host</u></h3>

    <p><strong>Name:</strong> {{ $job->gig->user->name }}</p>

    <p><strong>Email:</strong> <a href="mailto:{{ $job->gig->user->email }}">{{ $job->gig->user->email }}</a></p>

    @if ($job->gig->user->phone_number)
        <p><strong>Phone Number: </strong><a href="tel:{{ $job->gig->user->phone_number }}">{{ $job->gig->user->phone_number }}</a></p>
    @endif
    <br/>

    <p>Please add this gig to your calendar. You will also receive a reminder email two days before the event.</p>

    <p>Thank you for using Classical Connection RVA!</p>

    <br/>
    @if($canReject)
        <p>If you had no knowledge of this gig before this email and do not plan to participate in it, please click the link below to remove your name from this position.</p>
        <a href="{{ route('removeBooking', ['job_id' => $job->id, 'user_id' => $user->id, 'host_id' => $job->gig->user->id]) }}" style="background-color:#ef4444;border:none;color:white;padding:15px 32px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;">Remove Booking</a>
    @endif

</body>
</html>