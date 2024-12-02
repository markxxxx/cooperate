{include file="header.tpl"}
<div id="content">
    <div id="content-top">
        <h2>Select a domain</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">All unread messages</h4>
            <div class="box-container">
                <div id="sys-messages-container">
                    <h5>Latest Messages <span></span></h5>
                    <ul>
                        {section name=inst loop=$messages}
                            <li class="{cycle values="odd,even"}-messages"><a href="/domain/select/{$messages[inst].domain_id}?redirect=message/view/{$messages[inst].id}">{$messages[inst].reference} - {$messages[inst].title}</a></li>
                        {/section}
                    </ul>
                </div>
            </div>
        </div>
    </div> 

    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Please select a domain</h4>
            <div class="box-container">
                <form action="" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                    <h3>Please select a domain to manage </h3>
                    <p>Hi, you have managerial rights to multiple domains. Please select the one you would like to manage.</p>
                    <table class="table-long">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Programme</td>
                                <td>Referance</td>
                                <td>Users</td>
                                <td>Messages</td>
                                <td>Options</td>
                            </tr>
                        </thead>

                        <tbody>
                        {section name=inst loop=$domains}
                            <tr {cycle values="class='odd',"}>
                                <td>{$domains[inst].id}</td>
                                <td class="col-second"><a href="/domain/select/{$domains[inst].id}">{$domains[inst].domain}</a></td>
                                <td>{$domains[inst].reference}</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                        {/section}
                        </tbody>
                    </table>

            </div>
            </form>
        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}