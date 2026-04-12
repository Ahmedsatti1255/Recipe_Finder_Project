<?php
include 'db.php';
include 'navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id = '$user_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavor Finder | My Favorite Recipes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .favorites-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        .favorites-header {
            background: linear-gradient(135deg, #ff9a3c, #ff6b6b);
            color: white;
            padding: 40px 30px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(255, 106, 107, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .favorites-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" opacity="0.1"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>');
            background-repeat: no-repeat;
            background-size: contain;
        }
        
        .favorites-header h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            font-family: 'Georgia', serif;
        }
        
        .favorites-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
        }
        
        .favorites-stats {
            display: flex;
            gap: 30px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }
        
        .stat-item i {
            font-size: 1.5rem;
            color: #ffd166;
        }
        
        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .favorite-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .favorite-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .favorite-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ff6b6b;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            z-index: 2;
            box-shadow: 0 3px 10px rgba(255, 107, 107, 0.3);
        }
        
        .recipe-image {
            height: 200px;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            position: relative;
            overflow: hidden;
        }
        
        .recipe-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
        }
        
        .recipe-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .recipe-title {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
            line-height: 1.3;
        }
        
        .recipe-snippet {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 0.95rem;
            flex-grow: 1;
        }
        
        .recipe-actions {
            display: flex;
            gap: 15px;
            margin-top: auto;
        }
        
        .view-recipe-btn {
            flex-grow: 1;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .view-recipe-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }
        
        .remove-btn {
            background: #ffeaea;
            color: #ff6b6b;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .remove-btn:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            grid-column: 1 / -1;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #ffd166;
            margin-bottom: 20px;
        }
        
        .empty-state h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2rem;
        }
        
        .empty-state p {
            color: #666;
            max-width: 500px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        
        .browse-btn {
            display: inline-block;
            background: linear-gradient(to right, #ff9a3c, #ff6b6b);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .browse-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 106, 107, 0.3);
        }
        
        .favorites-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border: 2px solid #e1e5e9;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            color: #555;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            border-color: #4facfe;
            color: #4facfe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .favorites-grid {
                grid-template-columns: 1fr;
            }
            
            .favorites-header {
                padding: 30px 20px;
            }
            
            .favorites-header h1 {
                font-size: 2.2rem;
            }
            
            .favorites-stats {
                gap: 15px;
            }
            
            .recipe-actions {
                flex-direction: column;
            }
            
            .favorites-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .action-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="favorites-container">
        <div class="favorites-header">
            <h1>My Favorite Recipes</h1>
            <p>All your saved recipes in one place. Your personal cookbook curated just for you!</p>
            
            <div class="favorites-stats">
                <?php
                $fav_count = mysqli_num_rows($result);
                mysqli_data_seek($result, 0);
                ?>
                
                <div class="stat-item">
                    <i class="fas fa-heart"></i>
                    <span><strong><?php echo $fav_count; ?></strong> Saved Recipes</span>
                </div>
                
                <?php if ($fav_count > 0): ?>
                <div class="stat-item">
                    <i class="fas fa-book"></i>
                    <span>Your Personal Cookbook</span>
                </div>
                
                <div class="stat-item">
                    <i class="fas fa-utensils"></i>
                    <span>Ready to Cook</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="favorites-grid">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="favorite-card">
                    <div class="favorite-badge">
                        <i class="fas fa-heart"></i>
                    </div>
                    
                    <div class="recipe-image">
                        <!-- Placeholder for recipe image -->
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #666; font-size: 4rem;">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                    
                    <div class="recipe-content">
                        <h3 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="recipe-snippet"><?php echo htmlspecialchars($row['snippet']); ?></p>
                        
                        <div class="recipe-actions">
                            <a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank" class="view-recipe-btn">
                                <i class="fas fa-external-link-alt"></i> View Recipe
                            </a>
                            
                            <a href="remove_favorite.php?id=<?php echo $row['fav_id']; ?>"
                               onclick="return confirm('Remove <?php echo htmlspecialchars(addslashes($row['title'])); ?> from your favorites?');"
                               class="remove-btn">
                                <i class="fas fa-trash"></i> Remove
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <div class="favorites-actions">
                <a href="search.php" class="action-btn">
                    <i class="fas fa-search"></i> Find More Recipes
                </a>
                <a href="index.php" class="action-btn">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
            
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-heart-broken"></i>
                <h2>No Favorite Recipes Yet</h2>
                <p>You haven't saved any recipes yet. Start building your personal collection by exploring delicious recipes from around the world.</p>
                
                <a href="search.php" class="browse-btn">
                    <i class="fas fa-search"></i> Browse Recipes
                </a>
                
                <div style="margin-top: 40px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                    <div style="text-align: center;">
                        <div style="background: #ffefd6; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="fas fa-search" style="color: #ff9a3c; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-weight: 600;">Find Recipes</p>
                    </div>
                    <div style="text-align: center;">
                        <div style="background: #ffeaea; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="fas fa-heart" style="color: #ff6b6b; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-weight: 600;">Click Save</p>
                    </div>
                    <div style="text-align: center;">
                        <div style="background: #e6f7ff; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="fas fa-book" style="color: #4facfe; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-weight: 600;">Build Collection</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Add animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.favorite-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Initially set cards to be invisible for animation
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
            });
            
            // Enhance confirmation dialog
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const title = this.getAttribute('onclick').match(/Remove (.*?) from/)[1];
                    if (!confirm(`Are you sure you want to remove "${title}" from your favorites?`)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>