<?php if (have_rows('questions')): 
    $evolve_a = get_field('evolve_a'); 
    $pathway_a = get_field('path_a');
    $perf_a = get_field('perf_a'); ?>
<div id="quiz" class="quiz pt-5 pb-5">
    <div class="quiz-intro pb-4 container-xl">
    <h2>THE REBEL INDEX</h2>
            <p><strong>Where on the pathway to performance are you?</strong></p>
            <p>By answering the questions below around the business agility domains, we help you to identify your starting point and create an action plan for <strong>better, faster outcomes</strong></p>
            
    </div>
<div class="container-xl">
    <form id="sliderForm" method="POST">
        <?php 
        // Define questions with titles and text
        // If you create this component as a block, you can replace these with ACF fields 
        /*$questions = [
            "Inspired Leadership" => "Our performance and culture thrive on leadership that builds genuine relationships, empowers accountability, and unlocks potential. Inspired leadership drives better, faster outcomes.",
            "Dynamic Culture" => "We cultivate a culture of continuous learning, embracing diverse perspectives and tackling challenges with fearless collaboration.",
            "Digitally Driven" => "We rapidly capitalise on emerging tech, driven bu skilled individuals, effective processes, advanced technologoy, and strong governanace. Our tech management is user-centric, E2E, and iterative.",
            "Better Outcomes Faster" => "To continuously improve customer outcomes and achieve mastery, we need flexible strategies, fast value delivery, and dynamic team structures.",
            "Value Realised" => "To enhance impact, governance must be guided by outcome-focused metrics, a balanced approach to risk and reward, and ruthless prioritisation of those items that have the greatest impact.",
        ];*/

        $outputMessages = [
            'Evolve' => $evolve_a,
            'Pathway' => $pathway_a,
            'Performance' => $perf_a,
        ]; ?>
        <script>
            const outputMessages = <?= wp_json_encode($outputMessages); ?>;
        </script>

        <?php
        $num = 1;
        while (have_rows('questions')): the_row();
            $title = get_sub_field('q_title');
            $text = get_sub_field('q_text');
            $i = $num; // Use $num instead of array keys
            $sliderValue = isset($_POST["slider$i"]) ? (int)$_POST["slider$i"] : 2;
        ?>
            <div class="slider-container">
                <div class="slider-number"><?=$num ?></div>
                <div class="slider-inner">
                    <div class="question-title"><?= $title ?></div>
                    <div class="question-text"><?= $text ?></div>

                    <!-- Slider Labels -->
                    <div class="slider-labels">
                        <span>NEVER</span>
                        <span>SOMETIMES</span>
                        <span>ALWAYS</span>
                    </div>

                    <!-- Custom Slider -->
                    <div class="custom-slider ui-slider" id="custom-slider<?= $i ?>" data-index="<?= $i ?>" data-value="<?= $sliderValue ?>">
                        <span class="slider-handle" id="slider-handle<?= $i ?>" style="left: <?= ($sliderValue / 4) * 100 ?>%;"></span>
                    </div>

                    <!-- Hidden Range Input (for form submission) -->
                    <input type="range" class="hidden-range" id="slider<?= $i ?>" name="slider<?= $i ?>" min="0" max="4" value="<?= $sliderValue ?>">

                    <span class="sliderValue" id="value<?= $i ?>"><?= $sliderValue ?></span>
                </div>
            </div>

        <?php
            $num++;
        endwhile;
        
        ?>
    
        <span id="totalScore">0</span>
    
        <button id="calculateButton">Submit &gt;&gt;</button>
        
    </form>
    <div id="resultTitle" class="pt-5" style="display: none; font-size: 1.5em; font-weight: bold; margin-top: 20px;">
        <h2>Your<br>[Replace_R color="white"]Results[/Replace_R]</h2>
    </div>
    <div id="output" style="display: none; font-weight: bold; margin-top: 20px;">
        <div id="outputMessages">
        </div>
        <div class="form pt-5">
            <h2>BREAKING BARRIERS, BUT HUNGRY FOR MORE?</h2>
            <p><strong>You’re not just progressing – you’re preparing to revolutionise</strong></p>
            <p>Your scores scream potential, but potential without action is just a whisper. Share your details to unlock your full diagnostic insights, then let’s schedule a conversation about turning these insights into action</p>
            <div class="pt-4"><?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]');?></code>

    </div>
    </div>

<?php endif; ?>
    
<!-- don't put this in a separate script file as you won't be able to access $outputMessages -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let total = 0;

        const outputMessages = <?= json_encode($outputMessages) ?>;

        document.querySelectorAll(".custom-slider").forEach(slider => {
            let index = slider.dataset.index;
            let handle = document.getElementById("slider-handle" + index);
            let rangeInput = document.getElementById("slider" + index);
            let valueDisplay = document.getElementById("value" + index);
            let value = parseFloat(rangeInput.value);
            
            handle.style.left = (value / 4) * 100 + "%";
            total += Math.round(value);

            function updateSlider(clientX) {
                let rect = slider.getBoundingClientRect();
                let percent = (clientX - rect.left) / rect.width;
                let newValue = Math.round(percent * 4 * 10) / 10; // Allow smoother steps
                let roundedValue = Math.round(newValue); // Round for display & total score
                
                newValue = Math.max(0, Math.min(4, newValue)); // Ensure within range
                
                handle.style.left = (newValue / 4) * 100 + "%";
                rangeInput.value = newValue;
                valueDisplay.innerText = roundedValue;
            }

            slider.addEventListener("click", function (event) {
                updateSlider(event.clientX);
            });

            let dragging = false;

            handle.addEventListener("mousedown", function () {
                dragging = true;
                handle.classList.add("active");
            });

            document.addEventListener("mouseup", function () {
                dragging = false;
                handle.classList.remove("active");
            });

            document.addEventListener("mousemove", function (event) {
                if (dragging) {
                    updateSlider(event.clientX);
                }
            });

            // Touch events for mobile
            handle.addEventListener("touchstart", function () {
                dragging = true;
                handle.classList.add("active");
            });

            document.addEventListener("touchend", function () {
                dragging = false;
                handle.classList.remove("active");
            });

            document.addEventListener("touchmove", function (event) {
                if (dragging) {
                    updateSlider(event.touches[0].clientX);
                }
            });
        });

        function calculateTotal() {
            let sum = 0;
            document.querySelectorAll(".hidden-range").forEach(input => {
                sum += Math.round(parseFloat(input.value)); // Round before adding to total
            });
            return sum;
        }

        function revealOutput(total) {
            let outputDiv = document.getElementById("output");
            let outputMessagesDiv = document.getElementById("outputMessages");
            let outputTitle = document.getElementById("resultTitle");

            let messageKey = "";
            let messageText = "";

            if (total >= 0 && total <= 7) {
                messageKey = "Evolve";
                messageText = outputMessages.Evolve;
            } else if (total >= 8 && total <= 14) {
                messageKey = "Pathway";
                messageText = outputMessages.Pathway;
            } else {
                messageKey = "Performance";
                messageText = outputMessages.Performance;
            }

            // Render the output with HTML formatting
            outputMessagesDiv.innerHTML = `<h5>${messageKey}:</h5> ${messageText}`;
            outputDiv.style.display = "block";
            outputTitle.style.display = "block";
                // Scroll to the results section smoothly
            setTimeout(() => {
                document.getElementById("resultTitle").scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }, 300); // Small delay for visibility effect
        }

        document.getElementById("calculateButton").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission
            let totalScore = calculateTotal();
            let outputMessagesDiv = document.getElementById("outputMessages").innerText.trim();
            // Store in Gravity Form Hidden Fields
            let hiddenScoreField = document.querySelector("input[name='input_7']"); // Adjust to your Gravity Forms field ID
            let hiddenMessageField = document.querySelector("input[name='input_8']"); // Adjust for the second field

            if (hiddenScoreField) {
                hiddenScoreField.value = totalScore; // Store Score
            }

            if (hiddenMessageField) {
                hiddenMessageField.value = outputMessagesDiv;
            }

            document.getElementById("totalScore").innerText = totalScore;
            revealOutput(totalScore);
        });
    });
</script>