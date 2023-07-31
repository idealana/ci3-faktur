<?php if(!empty($data) && !empty($data['data_counts'])): ?>
	<div class="d-flex flex-md-nowrap flex-wrap">
		<?php foreach ($data['data_counts'] as $dataCount): ?>
			<div class="w-50 p-1">
				<div
					class="info-box mb-0 text-gray text-sm shadow-sm p-0 <?= $dataCount['border_type']; ?>"
					style="border-left: 4px solid; min-height: 60px;">
			    <div class="info-box-content">
			      <span class="info-box-text"><?= $dataCount['label']; ?></span>
			      <span class="info-box-number"><?= $dataCount['total']; ?></span>
			    </div>
			  </div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>