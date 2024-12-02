/***
 * Create blank command
 */
var FCKPull_command = function()
{

}

/***
 * Add Execute prototype
 */
FCKPull_command.prototype.Execute = function()
{
        // get whatever is selected in the FCKeditor window
        var selection = new String(FCK.EditorDocument.getSelection());
        
        // if there is a selection, add tags around it
        if(selection.length > 0)
        {
                FCK.InsertHtml('<span class="pull">' + selection + '</span>');
        } else {
                        // for debugging reasons, I added this alert so I see if nothing is selected
                alert('nothing selected');
        }
}

/***
 * Add GetState prototype
 * - This is one of the lines I can't explain
 */
FCKPull_command.prototype.GetState = function()
{
        return;
}

// register the command so it can be use by a button later
FCKCommands.RegisterCommand( 'Pull_command' , new FCKPull_command() ) ;

/***
 * Create the  toolbar button.
 */

// create a button with the label "Netnoi" that calls the netnoi_command
var oPull = new FCKToolbarButton( 'Pull_command', 'Pull qoute' ) ;
oPull.IconPath = FCKConfig.PluginsPath + 'pull/pull.gif' ;

// register the item so it can added to a toolbar
FCKToolbarItems.RegisterItem( 'Pull', oPull ) ;