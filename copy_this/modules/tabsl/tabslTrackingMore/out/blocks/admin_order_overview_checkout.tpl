[{$smarty.block.parent}]
[{ assign var="aTtmParcels" value=$edit->getTtmLastStatus() }]
[{ if $aTtmParcels|count > 0 }]
    <tr>
        <td>
            [{ foreach from=$aTtmParcels key=sTtmParcel item=aTtmParcel name=ttmParcels }]
                <b>[{ $sTtmParcel }]</b> ([{ $smarty.foreach.ttmParcels.iteration }]/[{ $smarty.foreach.ttmParcels.total }])<br>
                <a href="https://www.dhl.de/de/privatkunden/pakete-empfangen/verfolgen.html?piececode=[{ $sTtmParcel }]" target="_blank"><span style="color: [{ $aTtmParcel.label }]; font-weight: bold;"> [{ $aTtmParcel.status }]</span></a><br>
                [{ $aTtmParcel.date|oxformdate:'datetime':true }]<br><br>
            [{ /foreach }]
        </td>
    </tr>
[{ /if }]
