<?php
$columns = get_field('issues');
?>

<section class="issue-cols" style="position: relative;">
    <div class="container-xl py-5">
        <!-- Header Row -->
        <div class="row mb-4">
            <div class="col-12 pb-5">
                <h2>Achieve More With PerfectRebel</h2>
                <p>To thrive business, need to be adaptable, agile and resilient to quickly adjust focus at times of disruption or change</p>
                <p>We believe the businesses who can rise above this inertia, who can free their leaders up to lead and free up their teams to deliver will outperform the market</p>
            </div>
            <div class="col-lg-6 d-none d-lg-flex">
                <h4 class="header-title header-1">CURRENT<br>ISSUES</h4>
            </div>
            <div class="col-lg-6 d-none d-lg-flex">
                <h4 class="header-title header-2">DELIVERING BETTER OUTCOMES FASTER</h4>
            </div>
            <!--<div class="col-lg-4"></div>-->
        </div>

        <!-- Data Rows -->
        <div class="row g-4 align-solutions">
            <?php if ($columns): ?>
                <?php $index = 0; ?>
                <?php $total_rows = count($columns); ?>
                <?php foreach ($columns as $key => $column): ?>
                    <div class="col-lg-6">
                        <?php if (!empty($column['issue'])): ?>
                            <h4 class="d-lg-none">CURRENT<br>ISSUE</h4>
                            <div class="card-box issue d-flex flex-column h-100">
                                <div class="card-text flex-grow-1">
                                    <p><?php echo esc_html($column['issue']); ?></p>
                                    <div class="read-more">
                                        <p><?php echo esc_html($column['issue_rm']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-6">
                        <?php if (!empty($column['outcome'])): ?>
                            <h4 class="d-lg-none">OUTCOME</h4>
                            <div class="card-box outcomes d-flex flex-column h-100">
                                <div class="card-text flex-grow-1">
                                    <p><?php echo esc_html($column['outcome']); ?></p>
                                    <div class="read-more">
                                        <p><?php echo esc_html($column['outcome_rm']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>