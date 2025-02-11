<?php
$columns = get_field('issues');
?>

<section class="issue-cols" style="position: relative;">
    <div class="container py-5">
        <!-- Header Row -->
        <div class="row mb-4">
            <div class="col-12 pb-5"><h2>Achieve More With PerfectRebel</h2></div>
            <div class="col-lg-4">
                <h4 class="header-title header-1">CURRENT<Br>ISSUES</h4>
            </div>
            <div class="col-lg-4">
                <h4 class="header-title header-2">DELIVERING BETTER OUTCOMES FASTER</h4>
            </div>
            <div class="col-lg-4">
            </div>
        </div>

        <!-- Data Rows -->
        <div class="row g-4">
            <?php if ($columns): ?>
                <?php $index = 0; ?>
                <?php foreach ($columns as $column): ?>
                    <div class="col-lg-4">
                        <div class="card-box issue">
                            <div class="card-text">
                                <p><?php echo !empty($column['issue']) ? esc_html($column['issue']) : '&nbsp;'; ?></p>
                                <div class="read-more">
                                    <p><?php echo !empty($column['issue_rm']) ? esc_html($column['issue_rm']) : '&nbsp;'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card-box outcomes">
                            <div class="card-text">
                                <p><?php echo !empty($column['outcome']) ? esc_html($column['outcome']) : '&nbsp;'; ?></p>
                                <div class="read-more">
                                    <p><?php echo !empty($column['outcome_rm']) ? esc_html($column['outcome_rm']) : '&nbsp;'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card-box solution-box">
                            <div class="card-number">
                                <?php echo ++$index; ?>
                            </div>
                            <div class="card-solution">
                                <p class="solution-text"><?php echo !empty($column['solution']) ? wp_kses_post($column['solution']) : '&nbsp;'; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Extra Solutions Handling -->
                <?php
                $total_solutions = count(array_filter(array_column($columns, 'solution'))); // Count all valid solutions
                $total_rows = count($columns); // Total rows (issues + outcomes)
                if ($total_solutions > $total_rows): 
                    for ($i = $total_rows; $i < $total_solutions; $i++): 
                        ?>
                        <div class="col-lg-4">
                            <div class="card-box issue">&nbsp;</div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-box outcomes">&nbsp;</div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-box solution-box">
                                <div class="card-number">
                                    <?php echo ++$index; ?>
                                </div>
                                <div class="card-solution">
                                    <p class="solution-text"><?php echo wp_kses_post($columns[$i]['solution']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php 
                    endfor; 
                endif;
                ?>
            <?php endif; ?>
        </div>
    </div>
</section>