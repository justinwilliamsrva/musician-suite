<!DOCTYPE html>
<html>
<head>
    <title>New Job Available</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>We wanted to let you know that a new job is available for your instrument</p>

    <h2>{{ $gig->event_type }}</h2>

    <h3>Details</h3>

    <p><strong>Instrument(s):</strong> {{ implode(', ', json_decode($job->instruments)) }}</p>

    <p><strong>Date and Time:</strong> {{ date_format($gig->start_time, 'D, m/d/y g:i a').$gig->getEndTime($gig) }}</p>

    <p><strong>Location:</strong> {{ $gig->street_address.', '. $gig->city.', '.$gig->state.' '.$gig->zip_code }}</p>

    <p><strong>Payment:</strong> {{ '$'.$job->payment }}</p>

    @if($gig->description)
        <p><strong>Description:</strong> {{ $gig->description }}</p>
    @endif
    @if($gig->extra_details)
        <p><strong>extra_details:</strong> {{ $gig->extra_details }}</p>
    @endif

    <h3>Host</h3>

    <p><strong>Name:</strong> {{ $gig->user->name }}</p>

    <p><strong>Email:</strong> {{ $gig->user->email }}</p>

    <p><strong>Phone Number: </strong>{{ $gig->user->phone_number }}</p>

    <p>If you're interested in this job, please click the button below to log in to your account and apply.</p>

    <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <a href="{{ route('gigs.show', $gig->id) }}" style="background-color:#4CAF50;border:none;color:white;padding:15px 32px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;">View Job</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p>Thank you for using our platform!</p>
</body>
</html>