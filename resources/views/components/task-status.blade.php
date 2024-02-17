@props(['status'])


@if($status=="opened")
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8"/>
        </svg>
    </span>
@elseif($status=="pending")
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFEA4A" class="bi bi-circle-fill" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8"/>
        </svg>
    </span> 
@elseif($status=="closed")
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fe0131" class="bi bi-circle-fill" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8"/>
        </svg>
    </span>
@endif