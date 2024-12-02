<div class="push"></div>
</div>
<div id="footer-wrap">
    <div id="footer">
        <div id="footer-top">
            <div class="align-left">
                {if $user->group_id eq 6}
                    <h4>MISCELLANEOUS</h4>
                    <p><a href="/media/client_help.pdf">Help</a> | {if $user->id}| <a href="/user/logout">Logout</a>{/if}</p>
                {/if}
            </div>
            <div class="align-right">
                <h2><a href="http://www.studentvillage.co.za">Moshal scholarship program</a></h2>
            </div>
            <span class="clearFix"></span>
        </div>


    </div>
</div>
{if $smarty.const.DEBUG}
    {include file="profiler.tpl"}
{/if}
</body>
</html>