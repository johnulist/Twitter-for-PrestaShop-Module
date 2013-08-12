{$message}
<form method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>{l s='Twitter Box'}</legend>

        <div class="multishop_info">
            <ol>
                <li>1. Go to <a href="https://twitter.com/">Twitter</a> and sign in as normal.</li>
                <li>2. Go to your settings page.</li>
                <li>3. Go to "Widgets" on the left hand side.</li>
                <li>4. Create a new widget for what you need eg "user timeline" or "search" etc.</li>
                <li>5. Now go back to settings page, and then go back to widgets page, you should see the widget you just created. Click edit.</li>
                <li>6. Now look at the URL in your web browser, you will see a long number like this: 355763562850942976 . Use this as your ID below.</li>
            </ol>
            <br class="clear" />
        </div>
        <div class="opt clearfix">
            <label for="user">{l s='User'}</label>
            <div class="margin-form">
                <input id="user" type="text" name="user" value="{$user}" style="width:250px">
            </div>
        </div>
        <div class="opt clearfix">
            <label for="widget_id">{l s='Widget ID'}</label>
            <div class="margin-form">
                <input id="widget_id" type="text" name="widget_id" value="{$widget_id}" style="width:250px">
            </div>
        </div>
        <div class="opt clearfix">
            <label for="tweets_limit">{l s='Tweets limit'}</label>
            <div class="margin-form">
                <input id="tweets_limit" type="text" name="tweets_limit" value="{$tweets_limit}" style="width:250px">
            </div>
        </div>
        <div class="opt clearfix">
            <label for="follow_btn">{l s='Show Follow button'}</label>
            <div class="margin-form">
                <input id="follow_btn" type="checkbox" name="follow_btn" {if $follow_btn == 'on'}checked{/if}>
            </div>
        </div>

        <div class="margin-form">
            <input class="button" type="submit" name="saveBtn" value="{l s='Save'}">
        </div>
    </fieldset>
</form>