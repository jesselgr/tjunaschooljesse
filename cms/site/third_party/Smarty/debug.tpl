
<div id="ac_debug_assigned_vars">
    {foreach $assigned_vars as $vars}
   
   		{if $vars@key != 'this'}
       <div class="{if $vars@iteration % 2 eq 0}odd{else}even{/if} ac_deb_{$vars->value|@gettype}">   
        <h3>${$vars@key|escape:'html'} <small style="color: #444;">({$vars->value|@gettype})</small></h3>
     
      		<pre>{{$vars->value|@var_dump}|htmlentities}</pre>
      		
     	
       </div>
       {/if}
    {/foreach}
</div>



