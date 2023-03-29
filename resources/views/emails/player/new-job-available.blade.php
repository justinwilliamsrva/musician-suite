<!DOCTYPE html>
<html>
<head>
    <title>New Job Available</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>There is a new job available for your instrument!</p>

    <h3><u>Gig Details</u></h3>

    <p><strong>Event:</strong> <a href="{{ route('gigs.show', $gig->id) }}"> {{ $gig->event_type }}</a></p>

    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($job->instruments)) }}</p>

    <p><strong>Date and Time:</strong> {{ date_format($gig->start_time, 'D, m/d/y g:i a').$gig->getEndTime($gig) }}</p>

    <p><strong>Location:</strong> {{ $gig->street_address.', '. $gig->city.', '.$gig->state.' '.$gig->zip_code }}</p>

    <p><strong>Payment:</strong> {{ '$'.$job->payment }}</p>

    @if($gig->description)
        <p><strong>Description:</strong> {{ $gig->description }}</p>
    @endif
    @if($job->extra_info)
        <p><strong>Extra info:</strong> {{ $job->extra_info }}</p>
    @endif

    <br/>

    <h3><u>Host</u></h3>


    <p><strong>Name:</strong> {{ $gig->user->name }}</p>

    <p><strong>Email:</strong> <a href="mailto:{{ $job->gig->user->email }}">{{ $job->gig->user->email }}</a></p>

    <p><strong>Phone Number: </strong><a href="tel:{{ $job->gig->user->phone_number }}">{{ $job->gig->user->phone_number }}</a></p>

    <br/>

    <p>If you're interested in this job, please click the button below to apply.</p>

    <a href="{{ route('applyToJobGet', ['job' => $job->id, 'user' => $user->id]) }}" style="background-color:#4CAF50;border:none;color:white;padding:15px 32px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;">Apply Now</a>

    <br/>

    <p>Thank you for using Classical Connection RVA!</p>
</body>
</html>