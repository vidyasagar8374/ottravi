@if(isset($linkButton) && $linkButton)
<div class="iq-button link-button">
    <a href="{{$buttonUrl}}" class="btn text-capitalize position-relative" type="submit">
        <span class="button-text">{{$buttonTitle}}</span>
    </a>
</div>
@else
<div class="iq-button">
    <a href="{{$buttonUrl}}" class="btn text-uppercase position-relative" type="submit">
        <span class="button-text">{{$buttonTitle}}</span>
        <i class="fa-solid fa-play"></i>
    </a>
</div>
@endif
