<?php
$columns = get_field('issues');
?>

<section class="issue-cols" style="position: relative;">
    <div class="container py-5">
        <!-- Header Row -->
        <div class="row mb-4">
            <div class="col-12 pb-5"><h2>Achieve More With PerfectRebel</h2></div>
            <div class="col-lg-4">
                <h4 class="header-title">CURRENT<Br>ISSUES</h4>
            </div>
            <div class="col-lg-4">
                <h4 class="header-title">DELIVERING BETTER OUTCOMES FASTER</h4>
            </div>
            <div class="col-lg-4">
            </div>
        </div>

        <!-- Data Rows -->
        <div class="row g-4">
            <?php if ($columns): ?>
                <?php $index = 0; ?>
                <?php foreach ($columns as $column): ?>
                    <!-- First Column: Current Issues -->
                    <div class="col-lg-4">
                        <div class="card-box issue">
                            <div class="card-text">
                                <p><?php echo esc_html($column['issue']); ?></p>
                                <div class="read-more">
                                    <p><?php echo esc_html($column['issue_rm']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Column: Outcomes -->
                    <div class="col-lg-4">
                        <div class="card-box outcomes">
                            <div class="card-text">
                                <p><?php echo esc_html($column['outcome']); ?></p>
                                <div class="read-more">
                                    <p><?php echo esc_html($column['outcome_rm']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Third Column: Numbers with Inline Hover -->
                    <div class="col-lg-4">
                        <div class="card-box solution-box">
                            <div class="card-number">
                                <?php echo ++$index; ?>
                            </div>
                            <div class="card-solution">
                                <p class="solution-text"><?php echo esc_html($column['solution']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
