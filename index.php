<?php 
include 'db.php'; 
include 'navbar.php'; 

// Add page-specific styling and functionality
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavor Finder | Discover Delicious Recipes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .recipe-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 20px;
            text-align: center;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
        }
        
        .recipe-hero h1 {
            font-family: 'Georgia', serif;
            font-size: 3.5rem;
            margin-bottom: 10px;
            color: #ff9a3c;
        }
        
        .recipe-hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }
        
        .search-container {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-form {
            display: flex;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border-radius: 50px;
            overflow: hidden;
        }
        
        .search-input {
            flex-grow: 1;
            padding: 20px 25px;
            border: none;
            font-size: 1.1rem;
            background: white;
        }
        
        .search-input:focus {
            outline: none;
        }
        
        .search-button {
            background: linear-gradient(to right, #ff9a3c, #ff6b6b);
            color: white;
            border: none;
            padding: 0 35px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-button:hover {
            background: linear-gradient(to right, #ff8a2e, #ff5252);
            transform: translateY(-2px);
        }
        
        .search-button i {
            margin-right: 8px;
        }
        
        .search-examples {
            margin-top: 20px;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .search-examples span {
            margin: 0 10px;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .search-examples span:hover {
            color: #ff9a3c;
            text-decoration: underline;
        }
        
        .features-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            margin: 60px 20px;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            width: 250px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: #ff9a3c;
            margin-bottom: 15px;
        }
        
        .feature-card h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .feature-card p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .recipe-hero {
                padding: 50px 20px;
            }
            
            .recipe-hero h1 {
                font-size: 2.5rem;
            }
            
            .search-form {
                flex-direction: column;
                border-radius: 15px;
            }
            
            .search-input, .search-button {
                padding: 15px;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="recipe-hero">
        <h1>Flavor Finder</h1>
        <p>Discover mouthwatering recipes from around the world. Search by ingredient, cuisine, dietary need, or cooking time.</p>
        
        <div class="search-container">
            <form method="get" action="search.php" class="search-form">
                <input type="text" name="q" class="search-input" placeholder="Discover" required>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Find Recipes
                </button>
            </form>
            
            <div class="search-examples">
                Popular searches: 
                <span onclick="document.querySelector('.search-input').value='pasta dinner'">Pasta Dinner</span> • 
                <span onclick="document.querySelector('.search-input').value='healthy breakfast'">Healthy Breakfast</span> • 
                <span onclick="document.querySelector('.search-input').value='gluten-free dessert'">Gluten-Free Dessert</span> • 
                <span onclick="document.querySelector('.search-input').value='30 minute meals'">30-Minute Meals</span>
            </div>
        </div>
    </div>
    
    <div class="features-section">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <h3>10,000+ Recipes</h3>
            <p>From appetizers to desserts, find the perfect dish for any occasion.</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h3>Personalized Favorites</h3>
            <p>Save your favorite recipes and get recommendations based on your taste.</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3>Quick & Easy</h3>
            <p>Filter by cooking time to find recipes that fit your schedule.</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-user-friends"></i>
            </div>
            <h3>Community Rated</h3>
            <p>See reviews and ratings from fellow home cooks.</p>
        </div>
    </div>

    <script>
        // Example search suggestions functionality
        document.querySelectorAll('.search-examples span').forEach(span => {
            span.addEventListener('click', function() {
                document.querySelector('.search-input').value = this.textContent;
                document.querySelector('.search-form').submit();
            });
        });
        
        // Add animation to search bar on page load
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.querySelector('.search-form');
            searchForm.style.transform = 'translateY(0)';
            searchForm.style.opacity = '1';
        });
    </script>
</body>
</html>