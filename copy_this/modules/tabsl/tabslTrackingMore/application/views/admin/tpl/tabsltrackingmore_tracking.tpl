[{include file="headitem.tpl" title="tabsltrackingmore_tracking"|oxmultilangassign}]

[{ assign var="lfFrontendSrc" value=$oViewConf->getModuleUrl('lfFrontend','out/src/') }]
<link href='[{ $lfFrontendSrc }]css/rating.css' rel='stylesheet' type='text/css'>

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="tabsltrackingmore_tracking">
</form>


[{ assign var="aTtmParcels" value=$oView->getParcels() }]
[{ if $aTtmParcels|count > 0 }]
    <table border="0">
        <tr>
            [{ foreach from=$aTtmParcels key=sTtmParcel item=aTtmParcel }]
                <td style="padding-right: 15px;" valign="top">
                    <fieldset style="width: 300px;">
                        <legend> <a href="https://www.dhl.de/de/privatkunden/pakete-empfangen/verfolgen.html?piececode=[{ $sTtmParcel }]" target="_blank"><b>[{ $sTtmParcel }]</b></a> </legend>
                        <ul>
                            [{ foreach from=$aTtmParcel.status item=aTtmParcelStatus }]
                            <li style="list-style-type: none;">
                                [{ $aTtmParcelStatus.status }]<br>
                                [{ $aTtmParcelStatus.date|oxformdate:'datetime':true }]<br><br>
                            </li>
                            [{ /foreach }]
                        </ul>
                    </fieldset>
                </td>
            [{ /foreach }]
        </tr>
    </table>
[{ /if }]


[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
