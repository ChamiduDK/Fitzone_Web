<?php

// Check if user is logged in by verifying $_SESSION['user_id']
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

// Assume user ID is obtained through login session
$user_id = $_SESSION['user_id'];

include 'DBconfig.php';

// Fetch user health information using mysqli
$sql = "SELECT * FROM user_health WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Bind the user_id as integer
$stmt->execute();
$result = $stmt->get_result();
$user_health = $result->fetch_assoc();

if (!$user_health) {
    echo "User health information not found.";
    exit;
}

// Generate customized workout plan based on user time commitment and preferences
if ($user_health['time_commitment'] >= 6) {
    $workout_split = "6-day split: Chest, Back, Shoulders, Legs, Arms, and Core with one rest day.";
    $workout_details = "
        <ul>
            <li><strong>Day 1 - Chest:</strong> Bench Press, Incline Dumbbell Press, Chest Fly, Push-ups, Cable Crossover</li>
            <li><strong>Day 2 - Back:</strong> Deadlifts, Pull-Ups, Bent-Over Rows, Lat Pulldown, T-Bar Row</li>
            <li><strong>Day 3 - Shoulders:</strong> Overhead Press, Lateral Raises, Front Raises, Face Pulls, Shrugs</li>
            <li><strong>Day 4 - Legs:</strong> Squats, Lunges, Leg Press, Hamstring Curls, Calf Raises</li>
            <li><strong>Day 5 - Arms:</strong> Bicep Curls, Tricep Pushdowns, Hammer Curls, Skull Crushers, Cable Extensions</li>
            <li><strong>Day 6 - Core:</strong> Plank Variations, Russian Twists, Hanging Leg Raises, Mountain Climbers, Bicycle Crunches</li>
        </ul>
    ";
} elseif ($user_health['time_commitment'] == 5) {
    $workout_split = "5-day split: Upper Body, Lower Body, Push, Pull, and Core.";
    $workout_details = "
        <ul>
            <li><strong>Day 1 - Upper Body:</strong> Bench Press, Overhead Press, Pull-Ups, Bicep Curls, Tricep Extensions</li>
            <li><strong>Day 2 - Lower Body:</strong> Squats, Lunges, Deadlifts, Leg Extensions, Calf Raises</li>
            <li><strong>Day 3 - Push:</strong> Bench Press, Dumbbell Shoulder Press, Tricep Dips, Push-Ups, Chest Fly</li>
            <li><strong>Day 4 - Pull:</strong> Pull-Ups, Bent-Over Rows, Deadlifts, Face Pulls, Bicep Curls</li>
            <li><strong>Day 5 - Core:</strong> Plank Variations, Cable Woodchoppers, Leg Raises, Russian Twists, Bicycle Crunches</li>
        </ul>
    ";
} elseif ($user_health['time_commitment'] == 4) {
    $workout_split = "4-day split: Upper Body, Lower Body, Core & Cardio, and Flexibility/Recovery day.";
    $workout_details = "
        <ul>
            <li><strong>Day 1 - Upper Body:</strong> Bench Press, Pull-Ups, Dumbbell Shoulder Press, Bicep Curls, Tricep Extensions</li>
            <li><strong>Day 2 - Lower Body:</strong> Squats, Lunges, Leg Press, Calf Raises, Hamstring Curls</li>
            <li><strong>Day 3 - Core & Cardio:</strong> Plank, Russian Twists, Bicycle Crunches, HIIT Cardio (Jump Rope, Burpees, Mountain Climbers)</li>
            <li><strong>Day 4 - Flexibility/Recovery:</strong> Stretching Routine, Yoga Poses, Foam Rolling</li>
        </ul>
    ";
} elseif ($user_health['time_commitment'] == 3) {
    $workout_split = "3-day split: Full Body with rotating focus on Upper, Lower, and Core.";
    $workout_details = "
        <ul>
            <li><strong>Day 1 - Full Body (Upper Focus):</strong> Bench Press, Pull-Ups, Dumbbell Shoulder Press, Plank, Russian Twists</li>
            <li><strong>Day 2 - Full Body (Lower Focus):</strong> Squats, Deadlifts, Lunges, Calf Raises, Bicycle Crunches</li>
            <li><strong>Day 3 - Full Body (Core Focus):</strong> Deadlifts, Plank Variations, Leg Raises, Mountain Climbers, Russian Twists</li>
        </ul>
    ";
} elseif ($user_health['time_commitment'] == 2) {
    $workout_split = "2-day split: Full Body workouts focusing on compound movements for maximum efficiency.";
    $workout_details = "
        <ul>
            <li><strong>Day 1 - Full Body:</strong> Deadlifts, Squats, Bench Press, Pull-Ups, Plank</li>
            <li><strong>Day 2 - Full Body:</strong> Lunges, Overhead Press, Bent-Over Rows, Push-Ups, Bicycle Crunches</li>
        </ul>
    ";
} else {
    $workout_split = "1-day routine: Full Body workout focusing on compound exercises and high-intensity intervals.";
    $workout_details = "
        <ul>
            <li><strong>Full Body Routine:</strong> Deadlifts, Squats, Bench Press, Pull-Ups, HIIT Circuit (Jump Rope, Burpees, Mountain Climbers)</li>
        </ul>
    ";
}

// Exercise Selection based on primary goal
$exercise_selection = "";
switch ($user_health['primary_goal']) {
    case 'muscle':
        $exercise_selection = "Focus on compound lifts (e.g., Squats, Deadlifts, Bench Press) with isolation exercises (e.g., Bicep Curls, Tricep Extensions).";
        break;
    case 'weight_loss':
        $exercise_selection = "Combine HIIT cardio sessions with full-body exercises for fat burn (e.g., Burpees, Kettlebell Swings).";
        break;
    case 'endurance':
        $exercise_selection = "Incorporate circuit training and endurance exercises (e.g., Jump Rope, Cycling) with bodyweight movements.";
        break;
    case 'strength':
        $exercise_selection = "Focus on heavy compound lifts (e.g., Deadlifts, Squats, Bench Press) for maximal strength.";
        break;
    case 'fitness':
        $exercise_selection = "A combination of strength training and cardio for overall fitness.";
        break;
    case 'flexibility':
        $exercise_selection = "Focus on yoga, stretching, and mobility exercises to enhance flexibility.";
        break;
    default:
        $exercise_selection = "General fitness routine with a mix of cardio, strength, and flexibility exercises (e.g., Plank, Lunges, Rowing).";
}

// Cardio Recommendations based on cardio preference
$cardio_recommendations = "";
switch ($user_health['cardio_preference']) {
    case 'low':
        $cardio_recommendations = "30 minutes of light walking or swimming 3 times a week.";
        break;
    case 'medium':
        $cardio_recommendations = "20 minutes of moderate cycling or running, 4 times a week.";
        break;
    case 'high':
        $cardio_recommendations = "Interval sprints or HIIT 3-4 times a week for 20 minutes.";
        break;
}

// Sets, Reps, and Interval Recommendations based on experience level
$sets_reps_intervals = "";
switch ($user_health['experience_level']) {
    case 'beginner':
        $sets_reps_intervals = "3 sets of 12-15 reps with moderate weights for compound exercises.";
        break;
    case 'intermediate':
        $sets_reps_intervals = "4 sets of 8-12 reps with moderate to heavy weights for compound exercises.";
        break;
    case 'advanced':
        $sets_reps_intervals = "5 sets of 5-8 reps with heavy weights for compound exercises.";
        break;
    case 'expert':
        $sets_reps_intervals = "5-6 sets with advanced progressive overload techniques.";
        break;
}

// Warm-Up and Cool-Down based on workout environment
$warm_up = ($user_health['workout_environment'] == 'gym') ? "10-15 minutes on a treadmill or elliptical, followed by dynamic stretching." : "5-10 minutes of light cardio followed by stretching exercises.";
$cool_down = "10 minutes of static stretching focusing on major muscle groups.";

// Nutritional Tips based on diet preference
$nutritional_tips = "";
switch ($user_health['diet_preference']) {
    case 'vegan':
        $nutritional_tips = "Focus on plant-based protein sources like lentils, tofu, and quinoa.";
        break;
    case 'vegetarian':
        $nutritional_tips = "Include dairy and eggs for protein, along with plenty of vegetables.";
        break;
    case 'keto':
        $nutritional_tips = "Incorporate healthy fats, such as avocado and nuts, while minimizing carbs.";
        break;
    case 'paleo':
        $nutritional_tips = "Eat whole foods, such as lean meats, fish, and vegetables, avoiding processed foods.";
        break;
    case 'balanced':
        $nutritional_tips = "Ensure a balanced diet with proteins, carbs, and healthy fats for optimal results.";
        break;
}

// Water Intake recommendations based on user health
$water_intake = "Drink at least " . ($user_health['daily_water_intake'] > 0 ? $user_health['daily_water_intake'] : "2-3 liters") . " of water daily to stay hydrated.";

// Progression Plan (Add a placeholder text here)
$progression_plan = "Gradually increase weights and intensity every 4-6 weeks to challenge muscles and avoid plateau.";

// Tracking Strategy (Can be customized based on goals)
$tracking_strategy = "Track your progress by logging your workouts, sets, reps, and weight lifted using a fitness app or a workout journal.";

// Insert the workout plan into the database (optional)
$sql_insert = "INSERT INTO user_workout_plan 
               (user_id, workout_split, exercise_selection, cardio_recommendations, sets_reps_intervals, progression_plan, warm_up, cool_down, tracking_strategy, nutritional_tips, water_intake)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("issssssssss", $user_id, $workout_split, $exercise_selection, $cardio_recommendations, $sets_reps_intervals, $progression_plan, $warm_up, $cool_down, $tracking_strategy, $nutritional_tips, $water_intake);
$stmt_insert->execute();

// Display workout plan to the user with detailed exercises
echo "<h1>Your Personalized Workout Plan</h1>";
echo "<p><strong>Workout Split:</strong> $workout_split</p>";
echo "<p><strong>Workout Details:</strong> $workout_details</p>";
echo "<p><strong>Exercise Selection:</strong> $exercise_selection</p>";
echo "<p><strong>Cardio Recommendations:</strong> $cardio_recommendations</p>";
echo "<p><strong>Sets, Reps, Intervals:</strong> $sets_reps_intervals</p>";
echo "<p><strong>Warm-Up:</strong> $warm_up</p>";
echo "<p><strong>Cool-Down:</strong> $cool_down</p>";
echo "<p><strong>Tracking Strategy:</strong> $tracking_strategy</p>";
echo "<p><strong>Nutritional Tips:</strong> $nutritional_tips</p>";
echo "<p><strong>Water Intake:</strong> $water_intake</p>";
?>
