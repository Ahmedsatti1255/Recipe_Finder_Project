<?php 
include 'navbar.php'; 
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavor Finder | Recipe Search Results</title>
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
        
        .search-results-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        .search-header {
            background: linear-gradient(135deg, #ff9a3c, #ff6b6b);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(255, 106, 107, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .search-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" opacity="0.1"><path d="M9.5,3C13.09,3 16,5.91 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16C5.91,16 3,13.09 3,9.5C3,5.91 5.91,3 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/></svg>');
            background-repeat: no-repeat;
            background-size: contain;
        }
        
        .search-header h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            font-family: 'Georgia', serif;
        }
        
        .search-query {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 50px;
            margin-top: 15px;
            backdrop-filter: blur(10px);
        }
        
        .search-query i {
            color: #ffd166;
        }
        
        .results-count {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .search-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .new-search-btn {
            background: white;
            color: #ff6b6b;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .new-search-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .recipe-card {
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
        
        .recipe-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
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
        
        .recipe-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ff6b6b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 2;
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
        
        .save-favorite-btn {
            background: linear-gradient(to right, #ff9a3c, #ff6b6b);
            color: white;
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
        
        .save-favorite-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 106, 107, 0.3);
        }
        
        .no-results {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            grid-column: 1 / -1;
        }
        
        .no-results i {
            font-size: 5rem;
            color: #ffd166;
            margin-bottom: 20px;
        }
        
        .no-results h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2rem;
        }
        
        .no-results p {
            color: #666;
            max-width: 500px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        
        .search-suggestions {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-top: 40px;
            border-left: 4px solid #4facfe;
        }
        
        .search-suggestions h3 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .suggestion-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .suggestion-tag {
            background: white;
            border: 2px solid #e1e5e9;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .suggestion-tag:hover {
            background: #4facfe;
            color: white;
            border-color: #4facfe;
            transform: translateY(-2px);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 50px;
        }
        
        .page-btn {
            background: white;
            border: 2px solid #e1e5e9;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .page-btn.active {
            background: #4facfe;
            color: white;
            border-color: #4facfe;
        }
        
        .page-btn:hover:not(.active) {
            border-color: #4facfe;
            color: #4facfe;
        }
        
        @media (max-width: 768px) {
            .results-grid {
                grid-template-columns: 1fr;
            }
            
            .search-header {
                padding: 25px 20px;
            }
            
            .search-header h1 {
                font-size: 2.2rem;
            }
            
            .recipe-actions {
                flex-direction: column;
            }
            
            .suggestion-tags {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="search-results-container">
        <div class="search-header">
            <h1>Recipe Search Results</h1>
            <?php if(isset($_GET['q'])): ?>
                <div class="search-query">
                    <i class="fas fa-search"></i>
                    <span><?php echo htmlspecialchars($_GET['q']); ?></span>
                </div>
            <?php endif; ?>
            
            <div class="search-actions">
                <a href="index.php" class="new-search-btn">
                    <i class="fas fa-search"></i> New Search
                </a>
                <a href="favorites.php" class="new-search-btn" style="background: rgba(255,255,255,0.1); color: white;">
                    <i class="fas fa-heart"></i> View Favorites
                </a>
            </div>
        </div>
        
        <?php
        if(isset($_GET['q'])){
            $query = urlencode($_GET['q']." recipe");
            $apiKey = "Searchapikey";
            $cx = "cxkey";

            $url = "https://www.googleapis.com/customsearch/v1?q=$query&key=$apiKey&cx=$cx";
            $response = file_get_contents($url);
            $data = json_decode($response,true);

            if(!empty($data['items'])):
                $resultCount = count($data['items']);
        ?>
                <div class="results-count">Found <?php echo $resultCount; ?> recipe<?php echo $resultCount !== 1 ? 's' : ''; ?> for your search</div>
                
                <div class="results-grid">
                    <?php foreach($data['items'] as $item): 
                        // Extract domain for badge
                        $url_parts = parse_url($item['link']);
                        $domain = isset($url_parts['host']) ? str_replace('www.', '', $url_parts['host']) : 'Recipe';
                    ?>
                    <div class="recipe-card">
                        <div class="recipe-badge">
                            <i class="fas fa-external-link-alt"></i>
                            <?php echo htmlspecialchars($domain); ?>
                        </div>
                        
                        <div class="recipe-image">
                            <!-- You could add recipe image here if available -->
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #666; font-size: 4rem;">
                                <i class="fas fa-utensils"></i>
                            </div>
                        </div>
                        
                        <div class="recipe-content">
                            <h3 class="recipe-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="recipe-snippet"><?php echo htmlspecialchars($item['snippet']); ?></p>
                            
                            <div class="recipe-actions">
                                <a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank" class="view-recipe-btn">
                                    <i class="fas fa-external-link-alt"></i> View Recipe
                                </a>
                                <a href="save_favorite.php?title=<?php echo urlencode($item['title']); ?>&link=<?php echo urlencode($item['link']); ?>&snippet=<?php echo urlencode($item['snippet']); ?>" class="save-favorite-btn">
                                    <i class="fas fa-heart"></i> Save
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination would go here if you implement it -->
                <!--
                <div class="pagination">
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">Next</button>
                </div>
                -->
                
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h2>No Recipes Found</h2>
                    <p>We couldn't find any recipes matching "<?php echo htmlspecialchars($_GET['q']); ?>". Try adjusting your search terms or browse our suggestions below.</p>
                    
                    <div class="search-actions" style="justify-content: center;">
                        <a href="index.php" class="new-search-btn">
                            <i class="fas fa-search"></i> Try New Search
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <?php } else { ?>
            <div class="no-results">
                <i class="fas fa-exclamation-circle"></i>
                <h2>No Search Query</h2>
                <p>Please enter a search term to find recipes.</p>
                
                <div class="search-actions" style="justify-content: center;">
                    <a href="index.php" class="new-search-btn">
                        <i class="fas fa-search"></i> Go to Search
                    </a>
                </div>
            </div>
        <?php } ?>
        
        <div class="search-suggestions">
            <h3><i class="fas fa-lightbulb"></i> Popular Recipe Searches</h3>
            <div class="suggestion-tags">
                <a href="search.php?q=pasta" class="suggestion-tag">Pasta</a>
                <a href="search.php?q=chicken" class="suggestion-tag">Chicken</a>
                <a href="search.php?q=vegetarian" class="suggestion-tag">Vegetarian</a>
                <a href="search.php?q=dessert" class="suggestion-tag">Dessert</a>
                <a href="search.php?q=breakfast" class="suggestion-tag">Breakfast</a>
                <a href="search.php?q=healthy" class="suggestion-tag">Healthy</a>
                <a href="search.php?q=quick+easy" class="suggestion-tag">Quick & Easy</a>
                <a href="search.php?q=italian" class="suggestion-tag">Italian</a>
            </div>
        </div>
    </div>

    <script>
        // Add hover effect to save buttons
        document.querySelectorAll('.save-favorite-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add visual feedback
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Saved!';
                this.style.background = 'linear-gradient(to right, #4caf50, #8bc34a)';
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.style.background = '';
                }, 2000);
            });
        });
        
        // Animate cards on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.recipe-card');
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
        });
    </script>
</body>
</html>
