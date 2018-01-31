<div class="side-bar right-bar">
    <a href="javascript:void(0);" class="right-bar-toggle">
        <i class="zmdi zmdi-close-circle-o"></i>
    </a>
    <h4 class="">Notifications</h4>

    <div class="notification-list nicescroll">
        <ul class="list-group list-no-border user-list">
            @foreach (Auth::user()->getMentions(10) as $mention)
                <li class="list-group-item">
                    <a href="{{ route('transaction.edit', [$mention->transactionNote->transaction->id]) }}" class="user-list-item">
                        <div class="icon bg-pink">
                            <i class="zmdi zmdi-comment"></i>
                        </div>
                        <div class="user-desc">
                            <span class="name">{{ $mention->transactionNote->user->name }} mentioned you</span>
                            <span class="desc">{{ str_limit($mention->transactionNote->getNoteText(), 25, '...') }}</span>
                            <span class="time">{{ $mention->created_at->format('F j, Y \a\t g:iA') }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>