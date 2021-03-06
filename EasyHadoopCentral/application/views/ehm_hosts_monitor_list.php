<div class=span10>
	<table class="table table-striped table_hover">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo $common_hostname;?></th>
				<th><?php echo $common_ip_addr;?></th>
				<th><?php echo $common_node_role;?></th>
				<th><?php echo $common_mem_status;?></th>
				<th><?php echo $common_mem_status;?></th>
			</tr>
		</thead>
		<tbody>
		<?php $i = 1;foreach($results as $item):?>
			<tr>
				<td><?php echo $i?></td>
				<td><?php echo $item->hostname;?></td>
				<td><?php echo $item->ip;?></td>
				<td>
				<?php
				$tmp = explode(",",$item->role);
				foreach ($tmp as $k => $v):
				?>
					<script>
					function check_online_<?php echo $v;?>_<?php echo $item->host_id;?>()
					{
						$.getJSON('<?php echo $this->config->base_url();?>index.php/monitor/getpid/<?php echo $item->host_id;?>/<?php echo $v;?>', function(json){
							if(json.status == 'online')
							{
								html = '<span class="label label-success"><i class="icon-ok"></i>' + json.role + '</span>';
							}
							else
							{
								html = '<span class="label label-important"><i class="icon-remove"></i>' + json.role + '</span>';
							}
							$('#check_online_<?php echo $v;?>_<?php echo $item->host_id;?>').html(html);
						});
					}
					check_online_<?php echo $v;?>_<?php echo $item->host_id;?>();
					setInterval(check_online_<?php echo $v;?>_<?php echo $item->host_id;?>, 10000);
					</script>
					<div id="check_online_<?php echo $v;?>_<?php echo $item->host_id;?>"></div>
				<?php
				endforeach;
				?>

				</td>
				<td>
					<div class="progress">
						<div class="bar bar-success" style="" id="mem_stats_<?php echo $item->host_id;?>_free">Free</div>
						<div class="bar bar-danger" style="" id="mem_stats_<?php echo $item->host_id;?>_used">Used</div>
					</div>
					<script>
					function mem_stat_<?php echo $item->host_id;?>()
					{
						$.getJSON('<?php echo $this->config->base_url();?>index.php/monitor/memstats/<?php echo $item->host_id;?>', function(json){
						//alert(json.mem_free_percent);
						//alert(json.mem_used_percent);
							$('#mem_stats_<?php echo $item->host_id;?>_free').attr("style", "width: "+json.mem_free_percent+"%");
							$('#mem_stats_<?php echo $item->host_id;?>_used').attr('style', "width: "+json.mem_used_percent+"%");
							html = 'Total: ' + json.mem_total_abbr + ', Free: ' + json.mem_free_abbr + ', <br />Cached: ' + json.mem_cached_abbr + ', Buffers: ' + json.mem_buffers_abbr;
							$('#mem_stats_<?php echo $item->host_id;?>_numeric').html(html);
						});
					}
					mem_stat_<?php echo $item->host_id;?>();
					setInterval(mem_stat_<?php echo $item->host_id;?>, 2000);
					</script>
				</td>
				<td>
					<div id="mem_stats_<?php echo $item->host_id;?>_numeric">
					</div>
				</td>
			</tr>
		<?php $i++; endforeach;?>
		</tbody>
	</table>
	<div>
		<h3><?php echo $pagination;?></h3>
	</div>
</div>