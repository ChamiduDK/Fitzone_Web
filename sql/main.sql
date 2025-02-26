CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address VARCHAR(255) NOT NULL,
    membership ENUM('basic', 'premium', 'elite') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE product_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    size VARCHAR(50),
    flavor VARCHAR(50),
    expiration_date DATE,
    description TEXT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    description TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,               
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('Credit', 'Debit', 'Cash on Delivery', 'KoKo Pay', 'Mint Pay') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin_users (username, password) VALUES ('admin', '123');

CREATE TABLE Staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    role VARCHAR(50),
    email VARCHAR(100),
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Coaches (
    coach_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    specialization VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL
);

CREATE TABLE user_health (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    primary_goal ENUM('muscle', 'weight_loss', 'endurance', 'strength', 'fitness', 'flexibility') NOT NULL,
    secondary_goals VARCHAR(255),
    experience_level ENUM('beginner', 'intermediate', 'advanced', 'expert') NOT NULL,
    medical_conditions TEXT,
    fitness_assessment TEXT,
    mobility_issues TEXT,
    time_commitment INT NOT NULL,
    activity_level ENUM('sedentary', 'moderately_active', 'very_active') NOT NULL,
    cardio_preference ENUM('low', 'medium', 'high') DEFAULT 'medium',
    strength_preference ENUM('low', 'medium', 'high') DEFAULT 'medium',
    workout_environment ENUM('gym', 'home', 'outdoor') DEFAULT 'gym',
    diet_preference ENUM('vegan', 'vegetarian', 'keto', 'paleo', 'balanced') DEFAULT 'balanced',
    daily_water_intake INT DEFAULT 0
);

ALTER TABLE user_health
ADD COLUMN mobility_flexibility TEXT;

-- Table to store workout plans
CREATE TABLE user_workout_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    workout_split VARCHAR(255),
    exercise_selection TEXT,
    cardio_recommendations TEXT,
    sets_reps_intervals TEXT,
    progression_plan TEXT,
    warm_up TEXT,
    cool_down TEXT,
    tracking_strategy TEXT,
    nutritional_tips TEXT,
    water_intake TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    class_name VARCHAR(50) NOT NULL,
    appointment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


