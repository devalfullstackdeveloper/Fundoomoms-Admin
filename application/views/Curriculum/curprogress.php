<div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <h6>Added Curriculum of <?= $total_records ?> Days</h6>
                    <div class="progress">
                        <?php
                            $percentage = (180-($total_records));
                            $percentage = (180-$percentage);
                        ?>
					  	<div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="180"></div>
					</div>
					<span><?= $total_records ?></span>
					<span class="float-right"><?php echo $classdays; ?> Days</span>
                    </div>
                </div>
            </div>