<div class="content">
    <div class="title">Something went wrong.</div>

    @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
        <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

        <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            Raven.showReportDialog({
                eventId: '{{ Sentry::getLastEventID() }}',
                // use the public DSN (dont include your secret!)
                dsn: 'http://f722029a2417494a83aa945679b71d15@sentry.devswebdev.com/3',
                user: {
                    'name': 'Erlich Bachman',
                    'email': 'erlick@smallbizcrm.com',
                }
            });
        </script>
    @endif
    {{-- vfv --}}
</div>
