@component('mail::message')
# Application Status Update

Hello {{ $applicant->name }},

@if ($application->status === 'selected')
Congratulations, you have been selected for the **{{ $job->title }}** position at **{{ $job->company_name }}**.
@elseif ($application->status === 'rejected')
Thank you for applying for the **{{ $job->title }}** position at **{{ $job->company_name }}**. After reviewing your application, the employer has decided not to move forward with your application at this time.
@elseif ($application->status === 'shortlisted')
Good news! Your application for the **{{ $job->title }}** position at **{{ $job->company_name }}** has been shortlisted.
@else
Your application for the **{{ $job->title }}** position at **{{ $job->company_name }}** is currently pending review.
@endif

@component('mail::panel')
**Job:** {{ $job->title }}  
**Company:** {{ $job->company_name }}  
**Status:** {{ ucfirst($application->status) }}  
**Applied On:** {{ $application->created_at->format('M d, Y') }}
@endcomponent

@component('mail::button', ['url' => route('applicant.applications.show', $application)])
View Application
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent