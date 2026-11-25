CREATE DATABASE IF NOT EXISTS tourist_planner
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tourist_planner;

-- Drop in dependency order (child tables first)
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS attractions;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- ---------------------------------------------------------
-- users
-- ---------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- categories
-- ---------------------------------------------------------
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE,
    description TEXT
);

-- ---------------------------------------------------------
-- attractions
-- ---------------------------------------------------------
CREATE TABLE attractions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    category_id INT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    latitude DECIMAL(10,7) NOT NULL,
    longitude DECIMAL(10,7) NOT NULL,
    opening_hours VARCHAR(120) DEFAULT '',
    entrance_fee DECIMAL(10,2) DEFAULT 0,
    estimated_visit_minutes INT DEFAULT 90,
    safety_guidelines TEXT,
    image_url VARCHAR(500) DEFAULT '',
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attractions_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
);


CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attraction_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    rating TINYINT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (attraction_id) REFERENCES attractions(id) ON DELETE CASCADE,
    CONSTRAINT chk_rating CHECK (rating BETWEEN 1 AND 5)
);


INSERT INTO users (name, email, password, role)
VALUES (
    'System Administrator',
    'biheshad@gmail.com',
    '$2y$10$Gw15HY2NkmNeM46eiz1MmeKDdWeLPCGpjpsGkJ657oX08mg7BROgm',
    'admin'
);


INSERT INTO categories (id, name, description) VALUES
(1, 'Cultural',   'Religious and cultural landmarks such as temples and heritage sites.'),
(2, 'Nature',     'Gardens, lakes, forests and other natural attractions.'),
(3, 'Historical', 'Historic temples and traditional architecture.'),
(4, 'Adventure',  'Hiking spots and adventure destinations.'),
(5, 'Scenic',     'Viewpoints and scenic stops with panoramic views.');



INSERT INTO attractions
(
    name,
    category,
    category_id,
    description,
    location,
    latitude,
    longitude,
    opening_hours,
    entrance_fee,
    estimated_visit_minutes,
    safety_guidelines,
    image_url,
    featured
)
VALUES

(
    'Royal Botanical Gardens, Peradeniya',
    'Nature',
    2,
    'The Royal Botanical Gardens in Peradeniya is one of Sri Lanka''s most famous botanical attractions, established in 1821. The gardens feature thousands of plant species, including tropical trees, orchids, medicinal plants, giant bamboo and colourful ornamental flowers. Visitors can enjoy peaceful walks, nature photography, educational activities and family outings while learning about plant diversity and environmental conservation. The beautiful palm avenues and landscaped gardens make this an ideal destination for nature lovers and visitors exploring the Kandy region.',
    'Peradeniya, Kandy, Sri Lanka',
    7.2723000,
    80.5958000,
    'Daily 7:30 AM - 6:00 PM',
    200.00,
    180,
    'Wear comfortable walking shoes and carry drinking water. Stay on designated paths, avoid damaging plants or feeding wildlife, and supervise children near water. Use sun protection, dispose of rubbish properly and follow garden staff instructions.',
    'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1200&q=80',
    1
),

(
    'Gadaladeniya Raja Maha Vihara',
    'Cultural',
    1,
    'Gadaladeniya Raja Maha Vihara is an ancient Buddhist temple built in 1344 during the Gampola Kingdom. The temple is renowned for its distinctive stone architecture, historic inscriptions, Buddhist imagery and South Indian architectural influences. Visitors can explore the temple grounds, learn about medieval Sri Lankan history and appreciate the religious and cultural heritage of the region. Its peaceful surroundings make it a meaningful destination for pilgrims, history enthusiasts and travellers interested in traditional temple architecture.',
    'Gadaladeniya, Pilimathalawa, Kandy, Sri Lanka',
    7.2573000,
    80.5561000,
    'Suggested 6:00 AM - 6:00 PM; confirm locally',
    0.00,
    45,
    'Wear modest clothing and remove footwear where required. Speak quietly and respect religious ceremonies. Do not climb ancient structures or damage historical features. Walk carefully on uneven stone surfaces and follow temple photography rules.',
    'https://images.unsplash.com/photo-1606293926075-69a00dbfde81?auto=format&fit=crop&w=1200&q=80',
    0
),

(
    'Lankatilaka Vihara',
    'Cultural',
    1,
    'Lankatilaka Vihara is a historic Buddhist temple near Handessa in the Udunuwara area of Kandy. Dating from the fourteenth century, the temple is known for its distinctive architecture, historic inscriptions, decorative details and religious artwork. Visitors can explore its cultural heritage, learn about the Gampola Kingdom and enjoy views of the surrounding countryside. The temple provides an opportunity to appreciate traditional Sri Lankan craftsmanship and the historical development of Buddhist religious architecture.',
    'Handessa, Udunuwara, Kandy, Sri Lanka',
    7.2617000,
    80.5688000,
    'Suggested 6:00 AM - 6:00 PM; confirm locally',
    0.00,
    45,
    'Dress modestly and remove footwear in designated areas. Respect worshippers and avoid loud conversations. Do not climb walls, damage historic structures or touch fragile artwork. Take care on steps and uneven floors, especially during wet weather.',
    'https://images.unsplash.com/photo-1548013146-72479768bada?auto=format&fit=crop&w=1200&q=80',
    0
),

(
    'Embekka Devalaya',
    'Historical',
    3,
    'Embekka Devalaya is a historic shrine in Udunuwara, renowned for its exceptional traditional Sri Lankan woodcarvings. Associated with the Gampola Kingdom, the site features intricately carved wooden pillars, beams and decorative motifs depicting animals, flowers and traditional designs. Visitors can discover the craftsmanship of ancient Sri Lankan artisans, explore traditional architecture and learn about the religious and cultural traditions of the region. This heritage destination is particularly suitable for educational visits, cultural tourism and photography.',
    'Embekka, Udunuwara, Kandy, Sri Lanka',
    7.2395000,
    80.5688000,
    'Suggested 6:00 AM - 6:00 PM; confirm locally',
    0.00,
    45,
    'Wear modest clothing and remove footwear where instructed. Do not touch, scratch or lean against historic wooden carvings. Follow photography restrictions, walk carefully on uneven surfaces and respect religious activities. Keep children supervised and dispose of rubbish responsibly.',
    'https://images.unsplash.com/photo-1603565816030-6b389eeb23cb?auto=format&fit=crop&w=1200&q=80',
    0
),

(
    'Temple of the Sacred Tooth Relic',
    'Cultural',
    1,
    'The Temple of the Sacred Tooth Relic, also known as Sri Dalada Maligawa, is one of the most important Buddhist religious sites in Sri Lanka. Located in Kandy, it houses the sacred Tooth Relic of the Buddha and represents an important part of the country''s spiritual and cultural heritage. Visitors can appreciate traditional Kandyan architecture, explore historic religious buildings and learn about Buddhist rituals and the history of the Kandyan Kingdom. The temple attracts pilgrims and international visitors throughout the year.',
    'Sri Dalada Veediya, Kandy, Sri Lanka',
    7.2936000,
    80.6413000,
    'Daily 5:30 AM - 8:00 PM',
    0.00,
    90,
    'Wear clothing that covers the shoulders and knees. Remove footwear where required and respect prayers and religious ceremonies. Follow photography restrictions and keep valuables secure in crowded areas. Walk carefully on steps and floors, supervise children and follow official entry instructions.',
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1200&q=80',
    1
),

(
    'Kandy Lake',
    'Nature',
    2,
    'Kandy Lake is a scenic landmark in the heart of Kandy, situated beside the Temple of the Sacred Tooth Relic. Constructed in 1807, the lake is closely connected with the history of the Kandyan Kingdom. Visitors can enjoy lakeside walks, photography, birdwatching and views of the surrounding hills and historic buildings. The peaceful atmosphere makes it a popular destination for families, couples and travellers seeking a relaxing outdoor experience while exploring the city.',
    'Kandy City Centre, Kandy, Sri Lanka',
    7.2925000,
    80.6415000,
    'Suggested visiting hours 6:00 AM - 6:00 PM',
    0.00,
    60,
    'Remain on designated walking paths and keep a safe distance from the water. Do not swim or cross protective barriers. Supervise children, watch for traffic and avoid feeding wildlife or throwing rubbish into the lake. Walk carefully on wet surfaces and keep valuables secure.',
    'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1200&q=80',
    1
),

(
    'Udawatta Kele Sanctuary',
    'Nature',
    2,
    'Udawatta Kele Sanctuary is a protected forest reserve located behind the Temple of the Sacred Tooth Relic in Kandy. Historically associated with the royal forests of the Kandyan Kingdom, it provides an important natural habitat within the city. Visitors can explore forest trails, observe birds and other wildlife, enjoy nature photography and learn about biodiversity conservation. The shaded pathways and peaceful surroundings offer an enjoyable outdoor experience for nature lovers, hikers and educational groups.',
    'Udawatta Kele, Kandy, Sri Lanka',
    7.2990000,
    80.6420000,
    'Suggested 7:00 AM - 6:00 PM; confirm locally',
    75.00,
    120,
    'Wear sturdy shoes and carry drinking water. Remain on recognised trails and use insect repellent. Do not feed wildlife, remove plants or enter restricted areas. Avoid walking alone in unfamiliar sections and leave before closing time. Follow forest closure notices during heavy rain or dangerous weather.',
    'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1200&q=80',
    0
),

(
    'Bahirawakanda Vihara Buddha Statue',
    'Scenic',
    5,
    'The Bahirawakanda Vihara Buddha Statue is a prominent Buddhist landmark situated on a hill overlooking Kandy. The large white seated Buddha statue is visible from many parts of the city. Visitors can explore the temple surroundings, appreciate Buddhist religious traditions and enjoy panoramic views of Kandy and the surrounding hills. The elevated location is popular for sightseeing, photography and quiet reflection, especially during the early morning and late afternoon.',
    'Bahirawakanda, Kandy, Sri Lanka',
    7.2986000,
    80.6317000,
    'Suggested 6:00 AM - 6:00 PM; confirm locally',
    300.00,
    45,
    'Wear modest clothing and remove footwear where required. Use care on steps and sloping paths. Remain behind protective barriers and never climb walls or structures for photographs. Supervise children and avoid exposed viewpoints during thunderstorms or strong winds. Follow temple staff instructions.',
    'https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=1200&q=80',
    0
),

(
    'Ceylon Tea Museum',
    'Historical',
    3,
    'The Ceylon Tea Museum in Hantane near Kandy showcases the history and development of Sri Lanka''s internationally recognised tea industry. Housed in a historic tea-processing building, the museum displays traditional machinery, tea-processing equipment and exhibits about plantation life and tea production. Visitors can learn about the contribution of tea to the national economy, explore industrial heritage displays and discover the development of Ceylon tea. The elevated location also provides views of the surrounding hills.',
    'Hantane, Kandy, Sri Lanka',
    7.2720000,
    80.6250000,
    'Tuesday-Friday 8:30 AM - 4:00 PM; weekends 8:00 AM - 5:00 PM; Monday closed',
    1000.00,
    90,
    'Follow the designated visitor route and walk carefully on stairs. Do not touch or operate historical machinery or display equipment. Supervise children and respect restricted areas. Take care with hot drinks in café areas and follow museum staff instructions.',
    'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=1200&q=80',
    1
),

(
    'Ambuluwawa Tower',
    'Adventure',
    4,
    'Ambuluwawa Tower is a distinctive hilltop attraction in the Ambuluwawa Biodiversity Complex near Gampola. Famous for its unusual tower design, narrow spiral staircase and panoramic views, it attracts hikers, photographers and adventure enthusiasts. Visitors can explore the surrounding landscape, appreciate the biodiversity of the area and enjoy spectacular views of mountains and valleys when weather conditions are favourable. The tower provides a memorable outdoor experience for visitors who are comfortable with heights and enjoy scenic destinations.',
    'Ambuluwawa Biodiversity Complex, Gampola, Kandy, Sri Lanka',
    7.1647000,
    80.5736000,
    'Daily 7:30 AM - 5:30 PM; confirm locally',
    150.00,
    120,
    'Wear shoes with good grip and use handrails on stairs. Move slowly and avoid crowding narrow sections. Do not climb during strong winds, heavy rain, thunderstorms or poor visibility. Never lean over railings or climb barriers. Supervise children closely and follow site closure notices and staff instructions.',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
    1
);
