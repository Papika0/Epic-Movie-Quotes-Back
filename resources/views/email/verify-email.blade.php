<html>

<body
    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #181623; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
    <div style="padding: 35px ; overflow-wrap: anywhere;">
        <div style=" align-items: center; text-align: center; width: 100%; margin-bottom: 72px;">
            <img src="https://i.ibb.co/9Nmkkfg/Vector.png" title="Quote Icon" width="22px" height="22px"
                alt="not found" />
            <p
                style="color: #DDCCAA; font-size: 12px; text-align: center; align-items: center; width : 100% ; margin-top: 8px">
                MOVIE
                QUOTES</p>
        </div>

        <p style="color: white; margin-bottom: 24px;">Holl {{ $user->username }}!</p>
        <p style="color: white; margin-bottom: 32px;">Thanks for joining Movie quotes! We really appreciate it. Please
            click the button below
            to verify your account:</p>
        <a href="{{ $url }}"
            style="text-decoration: none; padding: 10px; border-radius: 6px; color: white; background-color: #E31221; margin-bottom: 40px;">
            Verify account
        </a>

        <p style="color: white; margin-bottom: 24px; margin-top: 20px">If clicking doesn't work, you can try copying and
            pasting it to
            your browser:</p>

        <p style="color: #DDCCAA; margin-bottom: 40px;">
            {{ $url }}
        </p>

        <p style="color: white; margin-bottom: 24px;">If you have any problems, please contact us:
            support@moviequotes.ge
        </p>
        <p style="color: white; margin-bottom: 24px;">MovieQuotes Crew</p>
    </div>

</body>

</html>
