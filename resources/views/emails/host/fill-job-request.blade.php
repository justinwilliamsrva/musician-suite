<!DOCTYPE html>
<html>
<head>
    <title>Fill Job Request</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>{{ $applicant->name }} has applied to the following job.</p>

    <br/>

    <h3><u>Gig Details</u></h3>
    <p><strong>Event:</strong> <a href="{{ route('gigs.show', $job->gig->id) }}"> {{ $job->gig->event_type }}</a></p>
    <p><strong>Date and Time:</strong> {{ date_format($job->gig->start_time, 'D, m/d/y g:i a').$job->gig->getEndTime() }}</p>
    <p><strong>Location:</strong> {{ $job->gig->street_address.', '. $job->gig->city.', '.$job->gig->state.' '.$job->gig->zip_code }}</p>
    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($job->instruments)) }}</p>
    <p><strong>Payment:</strong> {{ '$'.$job->payment }}</p>
    @if($job->extra_info)
        <p><strong>Extra info:</strong> {{ $job->extra_info }}</p>
    @endif

    <br/>

    <h3><u>Musician Details</u></h3>
    <p><strong>Name:</strong> {{ $applicant->name }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $applicant->email }}">{{ $applicant->email }}</a></p>
    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($applicant->instruments)) }}</p>

    <br/>

    <p>To book {{ $applicant->name }} for this job, please click the button below.</p>

    <a href="{{ route('bookJobGet', ['job' => $job->id, 'user' => $applicant->id]) }}" style="background-color:#4CAF50;border:none;color:white;padding:15px 32px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;">Book Musician</a>

    <br/>

    <p>Thank you for using Classical Connection RVA!</p>
</body>
</html>