-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 03:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techcafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `problem_description` text DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `first_name`, `last_name`, `phone`, `email`, `service`, `problem_description`, `appointment_date`, `appointment_time`, `created_at`, `status`) VALUES
(14, 'Wei Jian', 'Ng', '0162310148', 'ngaklol2@gmail.com', 'Virus Removal', 'I want to remove the virus from my pc as it is slowing down the performance of my games', '2025-05-06', '13:00:00', '2025-05-06 12:11:43', 'Completed'),
(15, 'Song Chen', 'Lim', '0163211232', '', 'PC Build', 'I want to build a gaming PC but I do not want it to be too expensive as  I am still a student in TARUMT', '2025-05-06', '14:00:00', '2025-05-06 12:15:21', 'Completed'),
(16, 'Nelson', 'Cheng', '0123214685', 'nelsonchengmingjian@gmail.com', 'Coworking Space', '', '2025-05-09', '17:00:00', '2025-05-06 12:17:03', 'Pending'),
(17, 'Kai Yang', 'Khor', '0131231876', '', 'Data Recovery', 'Bro please help i accidentally deleted my assignments files TT', '2025-05-06', '15:00:00', '2025-05-06 12:29:31', 'Completed'),
(18, 'Giggs', 'Teh', '0124278796', '', 'Coworking Space', '', '2025-05-08', '09:00:00', '2025-05-06 12:31:24', 'Pending'),
(19, 'John', 'Smith', '0198672321', 'johnsmith@gmail.com', 'Coworking Space', '', '2025-05-09', '11:00:00', '2025-05-06 12:32:04', 'Pending'),
(20, 'Cat', 'Legend', '01492832121', '', 'Turbocharge', '', '2025-05-16', '12:00:00', '2025-05-06 12:34:38', 'Pending'),
(21, 'Karen', 'Joy', '0172897542', '', 'Switch Fix', 'I need help please', '2025-05-13', '18:00:00', '2025-05-06 12:39:09', 'Pending'),
(22, 'James', 'Smith', '01842503821', '', 'Keyboard Build', '', '2025-05-17', '11:00:00', '2025-05-06 12:39:55', 'Pending'),
(23, 'Ming Hsien', 'Fan', '0124282412', 'fanminghsien@gmail.com', 'Keyboardd Soldering', '', '2025-05-11', '15:00:00', '2025-05-06 12:40:48', 'Pending'),
(24, 'Bryant', 'Yeoh', '0187522511', '', 'Keyboard Build', '', '2025-05-21', '17:00:00', '2025-05-06 12:41:22', 'Pending'),
(25, 'Kai Jie', 'Ch\'ng', '01628571674', '', 'Keyboard Cleaning', '', '2025-05-15', '09:00:00', '2025-05-06 12:42:13', 'Pending'),
(26, 'Eric', 'Ng', '0168922312', 'eric@gmail.com', 'Glitch Fix', 'Please help, my valorant app is not responding, everytime i open the app it just crashed', '2025-05-07', '18:00:00', '2025-05-06 12:44:43', 'Pending'),
(27, 'Ivan', 'Lim', '01976342321', '', 'Keyboard Disassembly', '', '2025-05-07', '16:00:00', '2025-05-06 12:45:24', 'Pending'),
(28, 'Pane', 'John', '01623182421', '', 'Switch Fix', '', '2025-05-08', '20:00:00', '2025-05-06 12:51:30', 'Pending'),
(29, 'Nelson', 'Jian', '0182284609', 'nelsonchengmingjian@gmail.com', 'pc_building', 'Why... Why is my assignment file corrupted... HELPPPPPPP', '2025-05-16', '19:40:00', '2025-05-06 13:42:42', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ItemsAdded` varchar(1000) NOT NULL,
  `Quantity` varchar(100) NOT NULL,
  `OrderStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `Email`, `ItemsAdded`, `Quantity`, `OrderStatus`) VALUES
(1, 'ccn@gmail.com', 'S011,S005,S020,S037', '466,1,1,1', 'InCart'),
(7, 'nelsonchengmingjian@gmail.com', 'S006', '9', 'Purchased'),
(9, 'nelsonchengmingjian@gmail.com', 'S006', '1', 'Purchased'),
(10, 'nelsonchengmingjian@gmail.com', 'S006', '1', 'Purchased'),
(11, 'nelsonchengmingjian@gmail.com', 'S006,S001', '1,1', 'Purchased'),
(12, 'nelsonchengmingjian@gmail.com', 'S001', '29', 'Purchased');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(4) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `ProductThumb` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Category`, `ProductThumb`) VALUES
('P001', 'Intel® Core™ i9 Processors (13th Gen)', 'Computer', 'intel.png'),
('P002', 'AMD Ryzen™ 9 Processors (7000 series)', 'Computer', 'amd.png'),
('P003', 'Nvidia GeForce RTX 4000 Series', 'Computer', 'nvidia.png'),
('P004', 'Kingston RAM Cards (DDR5)', 'Computer', 'kingston.png'),
('P005', 'Leobog Hi75 Barebone', 'Keyboard', 'hi75.jpg'),
('P006', 'Gateron G Pro 3.0', 'Keyboard', 'gateron.jpg'),
('P007', 'MonsGeek M1W Barebone', 'Keyboard', 'monsgeekm1w.jpg'),
('P008', 'Keycaps CSGO Themed', 'Keyboard', 'keycapscsgo.jpg'),
('P009', 'Razer Basilisk Series', 'Accessories', 'v3_pro.png'),
('P010', 'Harman Kardon Aura Studio 4', 'Accessories', 'harmankardon.png'),
('P011', 'Edifier QD35', 'Accessories', 'qd35.png'),
('P012', 'Razer Blackshark V2', 'Accessories', 'razerheadphone.png'),
('P013', 'Marshall Emberton II', 'Accessories', 'marshall-black.jpg'),
('P014', 'Prism + X270 PRO', 'Accessories', 'x270.jpg'),
('P015', 'Royal Kludge M75', 'Keyboard', 'm75.jpg'),
('P016', 'Kingston XS2000 External SSD', 'Accessories', 'ssd3.png');

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

CREATE TABLE `specification` (
  `SpecID` varchar(4) NOT NULL,
  `ProductID` varchar(4) NOT NULL,
  `Specification` varchar(100) NOT NULL,
  `Price` float NOT NULL,
  `Descr` longtext NOT NULL,
  `ProductPhoto` varchar(100) NOT NULL,
  `InventoryLevel` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`SpecID`, `ProductID`, `Specification`, `Price`, `Descr`, `ProductPhoto`, `InventoryLevel`) VALUES
('S001', 'P001', 'INTEL i9-13900F', 2456.63, 'The Intel i9-13900F CPU features 24 cores, consisting of 8 performance cores and 16 efficient cores, providing a total of 32 threads with a maximum turbo frequency of 5.60 GHz. It operates with a base power of 65W and can reach a maximum turbo power of 219W, while offering a 36 MB cache. The CPU supports up to 192 GB of memory, compatible with DDR4 (up to 3200 MT/s) and DDR5 (up to 5600 MT/s) memory types, delivering a memory bandwidth of 89.6 GB/s. It does not have integrated graphics, requiring a separate discrete GPU for graphical tasks. The processor is housed in an FCLGA1700 socket, with a package size of 45.0 mm by 37.5 mm.', 'i9-13900F.jpg', 5),
('S002', 'P001', 'INTEL i9-13900KF', 2517.14, 'The Intel i9-13900KF CPU is equipped with 24 cores, consisting of 8 performance cores and 16 efficient cores, resulting in a total of 32 threads. It has a maximum turbo frequency of 5.80 GHz and operates with a base power of 125W, with a maximum turbo power of 253W. The processor features a 36 MB cache. It supports a maximum memory size of 192 GB and is compatible with DDR4 memory (up to 3200 MT/s) and DDR5 memory (up to 5600 MT/s), offering a memory bandwidth of 89.6 GB/s. This CPU does not have integrated graphics, meaning it requires a discrete GPU. The processor uses an FCLGA1700 socket and has a package size of 45.0 mm by 37.5 mm.', 'i9-13900KF.jpg', 30),
('S003', 'P001', 'INTEL i9-13900', 2578.08, 'The Intel i9-13900 CPU features 24 cores, consisting of 8 performance cores and 16 efficient cores, resulting in a total of 32 threads. It boasts a maximum turbo frequency of 5.60 GHz, with a processor base power of 65W and a maximum turbo power of 219W. The CPU is equipped with a 36 MB cache. It supports a maximum memory size of 192 GB and is compatible with both DDR4 memory (up to 3200 MT/s) and DDR5 memory (up to 5600 MT/s), offering a memory bandwidth of 89.6 GB/s. For integrated graphics, the i9-13900 features Intel® UHD Graphics 770 with 32 execution units. It supports various resolutions, including 4096 × 2160 at 60Hz via HDMI, 7680 × 4320 at 60Hz via DisplayPort, and 5120 × 3200 at 120Hz via eDP. The processor uses an FCLGA1700 socket and has a package size of 45.0 mm × 37.5 mm.', 'i9-13900.jpg', 20),
('S004', 'P001', 'INTEL i9-13900K', 2587.45, 'The Intel i9-13900K is a high-performance CPU with 24 cores, consisting of 8 performance cores and 16 efficient cores, delivering a total of 32 threads. It features a maximum turbo frequency of 5.80 GHz, a processor base power of 125W, and a maximum turbo power of 253W. The CPU is equipped with a 36 MB cache. It supports a maximum memory size of 192 GB and is compatible with both DDR4 memory (up to 3200 MT/s) and DDR5 memory (up to 5600 MT/s), offering a memory bandwidth of 89.6 GB/s. The i9-13900K comes with integrated Intel® UHD Graphics 770, consisting of 32 execution units, and supports a variety of resolutions, including 4096 × 2160 at 60Hz via HDMI, 7680 × 4320 at 60Hz via DisplayPort, and 5120 × 3200 at 120Hz via eDP. This processor uses an FCLGA1700 socket and has a package size of 45.0 mm × 37.5 mm.', 'i9-13900K.jpg', 15),
('S005', 'P001', 'INTEL i9-13900KS', 3281.2, 'The Intel i9-13900KS is a high-end CPU with 24 cores, including 8 performance cores and 16 efficient cores, providing a total of 32 threads. It boasts an impressive maximum turbo frequency of 6.00 GHz, with a base power of 150W and a maximum turbo power of 253W. The CPU has a 36 MB cache. It supports up to 192 GB of memory, compatible with DDR4 (up to 3200 MT/s) and DDR5 (up to 5600 MT/s) memory types, and offers a maximum memory bandwidth of 89.6 GB/s. The i9-13900KS comes with integrated Intel® UHD Graphics 770, featuring 32 execution units. It supports high-resolution outputs with HDMI at 4096 × 2160 at 60Hz, DisplayPort at 7680 × 4320 at 60Hz, and eDP at 5120 × 3200 at 120Hz. The CPU uses the FCLGA1700 socket and has a package size of 45.0 mm × 37.5 mm.', 'i9-13900KS.jpg', 45),
('S006', 'P002', 'AMD RYZEN 9 7900', 1920.35, 'The AMD R9 7900 processor comes with 12 cores and 24 threads, featuring an L1 cache of 768 KB, an L2 cache of 12 MB, and an L3 cache of 64 MB. It operates at a base frequency of 3.75 GHz and can boost up to 5.40 GHz, with a base power consumption of 65 W. In terms of memory, it supports a maximum of 128 GB across two channels, with compatibility for DDR5 memory at speeds of up to 5200 MT/s. For graphics, it includes AMD Radeon™ Graphics with 2 cores running at a frequency of 2200 MHz. Additionally, the processor is designed for the AM5 socket.', 'ryzen_9_7900.jpg', 24),
('S007', 'P002', 'AMD RYZEN 9 7900X', 2565.2, 'The AMD Ryzen 9 7900X is a powerful processor with a total of 12 cores and 24 threads, designed to deliver high performance. It features an L1 cache of 768 KB, an L2 cache of 12 MB, and a large L3 cache of 64 MB, making it well-suited for demanding tasks. The CPU operates at a base frequency of 4.70 GHz, with a maximum turbo frequency of 5.60 GHz, offering exceptional speed for intensive applications. The processor has a base power consumption of 170W. It supports up to 128 GB of memory with a dual-channel configuration and can handle DDR5 memory running at speeds up to 5200 MT/s. For integrated graphics, the Ryzen 9 7900X comes with AMD Radeon™ Graphics, equipped with 2 graphics cores running at a frequency of 2200 MHz. The processor uses the AM5 socket, making it compatible with a wide range of modern motherboards.', 'ryzen_9_7900X.jpg', 30),
('S008', 'P002', 'AMD RYZEN 9 7900X3D', 3266.08, 'The AMD Ryzen 9 7900X3D is a high-performance processor with 12 cores and 24 threads, ideal for demanding computing tasks. It features an L1 cache of 768 KB, an L2 cache of 12 MB, and a sizable L3 cache of 64 MB, ensuring fast data access for intensive applications. The processor has a base frequency of 4.40 GHz, with a max turbo frequency of 5.60 GHz, providing excellent performance during heavy workloads. With a base power consumption of 120W, it offers a balance of power efficiency and performance. The Ryzen 9 7900X3D supports up to 128 GB of memory, operating in a dual-channel configuration, and is compatible with DDR5 memory running at speeds up to 5200 MT/s. For integrated graphics, it includes AMD Radeon™ Graphics with 2 graphics cores, running at a frequency of 2200 MHz. This processor uses the AM5 socket, ensuring compatibility with modern motherboards.', 'ryzen_9_7900X3D.jpg', 20),
('S009', 'P002', 'AMD RYZEN 9 7950X', 3266.08, 'The AMD Ryzen 9 7950X is a high-performance processor designed for demanding applications, featuring 16 cores and 32 threads. It offers a solid L1 cache of 1 MB, an L2 cache of 16 MB, and a large L3 cache of 64 MB for quick access to data. Operating at a base frequency of 4.00 GHz, it can boost up to 5.70 GHz for maximum performance under heavy workloads. With a base power consumption of 170 W, it balances efficiency and power. The Ryzen 9 7950X supports up to 128 GB of memory across two channels, and it is compatible with high-speed DDR5 memory running up to 5200 MT/s. The processor also includes integrated AMD Radeon™ Graphics, with 2 graphics cores running at 2200 MHz. It is designed to fit the AM5 socket, ensuring compatibility with the latest motherboard designs.', 'ryzen_9_7950X.jpg', 45),
('S010', 'P002', 'AMD RYZEN 9 7950X3D', 3266.08, 'The AMD Ryzen 9 7950X3D is a high-end processor designed for demanding tasks, equipped with 16 cores and 32 threads. It boasts an L1 cache of 1 MB, an L2 cache of 16 MB, and a massive L3 cache of 128 MB, allowing for faster data access and enhanced performance. With a base frequency of 4.00 GHz and a maximum turbo frequency of 5.70 GHz, it can handle intensive workloads with ease. The processor has a base power consumption of 120 W, making it energy-efficient while delivering high performance. It supports up to 128 GB of memory across two channels, with compatibility for DDR5 memory running at speeds of up to 5200 MT/s. The Ryzen 9 7950X3D also integrates AMD Radeon™ Graphics, featuring 2 graphics cores with a frequency of 2200 MHz. This processor is designed to fit the AM5 socket, ensuring compatibility with the latest motherboards.', 'ryzen_9_7950X3D.jpg', 30),
('S011', 'P003', 'GeForce RTX 4060Ti', 1862.33, 'The GeForce RTX 4060 Ti features 4,352 NVIDIA CUDA® Cores with a base clock of 2.31 GHz and a boost clock of 2.54 GHz. It is available with either 8 GB or 16 GB of GDDR6 memory and uses a 128-bit memory interface. The GPU supports resolutions up to 4K at 240Hz or 8K at 60Hz with DSC and HDR, and includes standard display connectors such as HDMI and three DisplayPorts. It supports up to four monitors and includes HDCP 2.3 support. In terms of physical dimensions, the card is 244 mm in length, 98 mm in width, and occupies two slots. Thermally, the GPU can reach a maximum temperature of 90°C, with an average gaming power consumption of 140W and a total graphics power of 165W (or 160W for some variants), requiring a system power supply of at least 550W. Power is delivered via a single PCIe 8-pin cable, or optionally via a 300W or greater PCIe Gen 5 cable, with adapters included in the box for compatibility.', '4060Ti.png', 15),
('S012', 'P003', 'GeForce RTX 4070', 2795.83, 'The GeForce RTX 4070 is equipped with 5,888 NVIDIA CUDA® Cores, offering a base clock speed of 1.92 GHz and a boost clock of 2.48 GHz. It comes with 12 GB of GDDR6X memory and a 192-bit memory interface, delivering high-speed performance for demanding applications. The GPU supports a maximum resolution of 4K at 240Hz or 8K at 60Hz with DSC and HDR, and is fitted with standard display outputs including HDMI and three DisplayPorts. It supports up to four simultaneous displays and includes HDCP 2.3 support. The card measures 244 mm in length and 112 mm in width, occupying two slots in a PC case. It has a maximum GPU temperature of 90°C, with an average gaming power draw of 186W and a total graphics power of 200W, requiring a minimum system power of 650W. Power can be supplied through two PCIe 8-pin cables or a 300W or greater PCIe Gen 5 cable, with an adapter included for convenience.', '4070.jpg', 10),
('S013', 'P003', 'GeForce RTX 4080', 5596.33, 'The GeForce RTX 4080 features 9,728 NVIDIA CUDA® Cores, with a base clock speed of 2.21 GHz and a boost clock of 2.51 GHz. It is equipped with 16 GB of ultra-fast GDDR6X memory and a 256-bit memory interface, offering excellent bandwidth for high-resolution gaming and intensive workloads. This GPU supports a maximum resolution of 4K at 240Hz or 8K at 60Hz using DSC and HDR, and includes HDMI and three DisplayPort connectors for versatile display options. It supports up to four monitors and is HDCP 2.3 compliant. Measuring 304 mm in length and 137 mm in width, the card takes up three slots. It maintains a maximum operating temperature of 90°C, with an average gaming power consumption of 251W and a total graphics power of 320W. The recommended system power supply is 750W. Power can be delivered through three PCIe 8-pin cables (adapter included) or a single 450W or greater PCIe Gen 5 cable.', '4080.png', 15),
('S014', 'P003', 'GeForce RTX 4090', 7463.33, 'The GeForce RTX 4090 boasts 16,384 NVIDIA CUDA® Cores, a base clock speed of 2.23 GHz, and a boost clock of 2.52 GHz. This powerhouse comes with a massive 24 GB of GDDR6X memory and a 384-bit memory interface, ensuring exceptional performance for 4K gaming and demanding applications. It supports a maximum resolution of 4K at 240Hz or 8K at 60Hz using DSC and HDR, with HDMI and three DisplayPort connectors, allowing for up to four monitors. The card is HDCP 2.3 compliant. With dimensions of 304 mm in length and 137 mm in width, it occupies three slots in the system. The maximum GPU temperature is 90°C, and the average gaming power consumption is 315W, with a total graphics power of 450W. The recommended system power is 850W. Power connectors required include three PCIe 8-pin cables (adapter included) or a single 450W or greater PCIe Gen 5 cable.', '4090.png', 20),
('S015', 'P004', 'Beast DDR5 (8GB)', 315, 'The Beast DDR5 8GB module is a UDIMM form factor memory stick, certified for both Intel XMP and AMD EXPO, providing Plug N Play functionality for easy setup. It operates at a speed of 4800 MHz with a CAS latency of 40 and a voltage of 1.1V. The module has a capacity of 8GB and is available in kit capacities of 16GB and 32GB, supporting both single and dual-channel configurations, but does not support quad-channel kits. The module\'s height without RGB is 34.9mm, and it comes with a lifetime warranty.', 'beastddr5.jpeg', 50),
('S016', 'P004', 'Beast DDR5 RGB (8GB)', 329, 'The Beast DDR5 8GB module is a UDIMM form factor memory stick, certified for both Intel XMP and AMD EXPO, providing Plug N Play functionality for easy setup. It operates at a speed of 4800 MHz with a CAS latency of 40 and a voltage of 1.1V. The module has a capacity of 8GB and is available in kit capacities of 16GB and 32GB, supporting both single and dual-channel configurations, but does not support quad-channel kits. The module\'s height without RGB is 34.9mm, and it comes with a lifetime warranty.', 'beastddr5rgb.jpg', 55),
('S017', 'P004', 'Renegade DDR5 (16GB)', 359, 'The Renegade DDR5 16GB module is available in a UDIMM form factor and is Intel XMP certified, but not AMD EXPO certified. It also features Plug N Play functionality. It operates at a speed of 6000 MHz with a CAS latency of 32 and a voltage of 1.35V. The module\'s capacity is 16GB, and it is available in kit capacities ranging from 32GB to 64GB. It supports single and dual-channel kits but does not support quad or octal channel kits. The height of the module without RGB is 39.2mm, and it comes with a lifetime warranty.', 'renegadeddr5.jpg', 60),
('S018', 'P004', 'Renegade DDR5 RGB (16GB)', 499, 'The Renegade DDR5 16GB module is available in a UDIMM form factor and is Intel XMP certified, but not AMD EXPO certified. It also features Plug N Play functionality. It operates at a speed of 6000 MHz with a CAS latency of 32 and a voltage of 1.35V. The module\'s capacity is 16GB, and it is available in kit capacities ranging from 32GB to 64GB. It supports single and dual-channel kits but does not support quad or octal channel kits. The height of the module without RGB is 39.2mm, and it comes with a lifetime warranty.', 'renegadeddr5rgb.jpg', 40),
('S019', 'P004', 'Renegade Pro (16GB)', 585, 'The Renegade Pro DDR5 16GB memory module is designed in UDIMM form factor, with Intel XMP certification but no AMD EXPO certification. It does not support Plug N Play functionality. The memory operates at a speed of 4800 MHz with a CAS latency of 36 and a voltage of 1.1V. The module capacity is 16GB, and the kit capacity is 64GB. It is available as single modules and dual-channel kits, but it does not offer quad-channel or octal-channel kits. The PCB color is black, and the heat spreader is also black. The height of the module is 31.25mm, and it comes with a lifetime warranty.', 'renegadepro.jpg', 45),
('S020', 'P004', 'Impact DDR5 (8GB)', 199, 'The Impact DDR5 memory module comes in a SODIMM form factor and is certified for Intel XMP but not for AMD EXPO. It supports Plug N Play functionality for easy use. The module operates at a speed of 4800 MHz with a CAS latency of 40 and a voltage of 1.1V. It has a module capacity of 8GB and is available in kit capacities of 16GB to 32GB. The module supports single modules and dual channel kits but does not support quad channel kits or octal channel kits. The PCB color is black, and the heat spreader color is also black. The module\'s height is 30mm, and it is backed by a lifetime warranty.', 'impactddr5.jpg', 35),
('S021', 'P005', 'Black', 289, 'The Leobog Hi75 Keyboard Kit offers a premium 75% keyboard experience with a sleek CNC Aluminium Body and a stylish Ruby Clear Knob. This kit is designed for a wired mode connection and features SOUTH FACING hot-swappable 5-pin switches, allowing for easy customization. It includes prelubed plate mounted stabilizers, a Polypropylene (PP) plate, and a Poron gasket, ensuring a smooth and responsive typing experience. The keyboard also comes with Poron plate foam, Poron case foam, and an IXPE switch pad to enhance acoustics and feel. A detachable Type C cable ensures convenience, and the full RGB lighting adds a touch of personalization. The keyboard supports all-keys anti-ghosting, a 1000Hz polling rate, and is compatible with both Windows and Mac systems. The kit also provides Leobog software support and is easy to use with a simple plug-and-play setup. In the box, you\'ll find the Leobog Hi75 Keyboard Kit, a Type A to Type C coiled cable, two Leobog switches, and a user manual.', 'hi75_Black.png', 20),
('S022', 'P005', 'Blue', 289, 'The Leobog Hi75 Keyboard Kit offers a premium 75% keyboard experience with a sleek CNC Aluminium Body and a stylish Ruby Clear Knob. This kit is designed for a wired mode connection and features SOUTH FACING hot-swappable 5-pin switches, allowing for easy customization. It includes prelubed plate mounted stabilizers, a Polypropylene (PP) plate, and a Poron gasket, ensuring a smooth and responsive typing experience. The keyboard also comes with Poron plate foam, Poron case foam, and an IXPE switch pad to enhance acoustics and feel. A detachable Type C cable ensures convenience, and the full RGB lighting adds a touch of personalization. The keyboard supports all-keys anti-ghosting, a 1000Hz polling rate, and is compatible with both Windows and Mac systems. The kit also provides Leobog software support and is easy to use with a simple plug-and-play setup. In the box, you\'ll find the Leobog Hi75 Keyboard Kit, a Type A to Type C coiled cable, two Leobog switches, and a user manual.', 'hi75_Blue.png', 25),
('S023', 'P005', 'White', 289, 'The Leobog Hi75 Keyboard Kit offers a premium 75% keyboard experience with a sleek CNC Aluminium Body and a stylish Ruby Clear Knob. This kit is designed for a wired mode connection and features SOUTH FACING hot-swappable 5-pin switches, allowing for easy customization. It includes prelubed plate mounted stabilizers, a Polypropylene (PP) plate, and a Poron gasket, ensuring a smooth and responsive typing experience. The keyboard also comes with Poron plate foam, Poron case foam, and an IXPE switch pad to enhance acoustics and feel. A detachable Type C cable ensures convenience, and the full RGB lighting adds a touch of personalization. The keyboard supports all-keys anti-ghosting, a 1000Hz polling rate, and is compatible with both Windows and Mac systems. The kit also provides Leobog software support and is easy to use with a simple plug-and-play setup. In the box, you\'ll find the Leobog Hi75 Keyboard Kit, a Type A to Type C coiled cable, two Leobog switches, and a user manual.', 'hi75_White.jpg', 30),
('S024', 'P006', 'Brown Switch', 0.9, 'The G Pro 3.0 Brown Switch is a linear switch with a smooth keystroke, featuring an operation force of 55±15 gf, a 2.0±0.6 mm pre-travel, and a 4.0 mm total travel, providing a balanced keypress with a 50 gf bottom-out force for a light yet tactile response. Its 20.5 mm spring ensures a clear rebound, while the 100-million-cycle lifespan guarantees durability, and the finger strike feeling offers a subtle bump, moderate pressing force, and distinct tactile feedback for a comfortable and responsive typing experience.', 'gateronbrown.jpg', 500),
('S025', 'P006', 'Yellow Switch', 1, 'The G Pro 3.0 Yellow Switch is a linear switch designed for smooth, consistent keystrokes, featuring a light 50±15 gf operation force, a 2.0±0.6 mm pre-travel, and a 4.0 mm total travel for a balanced keypress with a slightly firmer 67 gf bottom-out force. Its shorter 15.4 mm spring enhances responsiveness, delivering a clear rebound, while the 100-million-cycle lifespan ensures long-term durability. The finger strike feeling is characterized by a vertical, direct press with moderate resistance and a sharp return, making it ideal for fast, precise typing and gaming.', 'gateronyellow.jpg', 1000),
('S026', 'P006', 'Red Switch', 0.9, 'The G Pro 3.0 Red Switch is a smooth linear switch with an ultra-light 45±15 gf operation force, making it ideal for rapid keystrokes. It features a 2.0±0.6 mm pre-travel and 4.0 mm total travel, ensuring a fast yet balanced keypress with a 50 gf bottom-out force for a cushioned landing. The 20.5 mm spring provides a soft rebound, reducing fatigue during extended use, while its 100-million-cycle lifespan guarantees long-lasting performance. With a vertical keypress and light pressing force, this switch offers effortless, fluid typing—perfect for gamers and typists who prefer minimal resistance.', 'gateronred.jpg', 1000),
('S027', 'P006', 'Black Switch', 1.5, 'The G Pro 3.0 Black Switch is a linear switch designed for users who prefer a heavier, more deliberate keystroke. With a 60±15 gf operation force and a firm 70 gf bottom-out force, it delivers a solid, resistance-heavy typing experience. The 2.0±0.6 mm pre-travel and 4.0 mm total travel ensure consistent actuation while maintaining a deep, satisfying keypress. Its shorter 15.4 mm spring contributes to a hard rebound, providing sharp feedback with each press—ideal for precise control in gaming or heavy-handed typing. Built to last 100 million cycles, this switch combines durability with a vertical, force-driven feel that minimizes accidental presses and maximizes stability.', 'gateronblack.jpg', 1500),
('S028', 'P006', 'White Switch', 1.4, 'The G Pro 3.0 White Switch is an ultra-light linear switch designed for effortless keystrokes, featuring an exceptionally low 38±15 gf operation force and a gentle 45 gf bottom-out force for feather-light typing. With 2.0±0.6 mm pre-travel and 4.0 mm total travel, it offers a smooth, shallow press that enables rapid actuation—perfect for speed-focused typists and gamers. The 20 mm spring ensures a soft rebound, reducing finger fatigue during prolonged use, while the 100-million-cycle lifespan guarantees enduring reliability. Its vertical key travel and very light pressing force create a fluid, barely-there typing experience, making it ideal for those who prioritize minimal resistance and seamless responsiveness.', 'gateronwhite.jpg', 1250),
('S029', 'P006', 'Silver Switch', 1.4, 'The G Pro 3.0 Silver Switch is a speed-oriented linear switch engineered for lightning-fast responsiveness, featuring a 45±15 gf operation force and an ultra-short 1.2±0.3 mm pre-travel—one of the fastest actuations available. With a reduced 3.4 mm total travel and a light 50 gf bottom-out force, it minimizes finger movement while maintaining a moderate bottom-out feel for subtle tactile confirmation. The extended 22 mm spring ensures a fast rebound, snapping back quickly to enable rapid, repeated keystrokes—ideal for competitive gaming and high-speed typing. Built to endure 100 million cycles, this switch combines durability with a vertical, low-resistance keypress that prioritizes speed without sacrificing control or comfort.', 'gateronsilver.jpg', 1300),
('S030', 'P007', 'Black', 399, 'The MonsGeek M1W Wireless Aluminum Keyboard Barebone delivers ultimate versatility with tri-mode connectivity (2.4GHz, Bluetooth, USB-C), a south-facing PCB for Cherry keycap compatibility, and vibrant RGB backlighting (20+ presets, 16M colors via Cloud Driver). Enhanced typing acoustics come from PORON plate foam, a flexible polycarbonate plate, and plate-mounted stabilizers, while a 3mm PORON case foam upgrade and VHB insulation layer improve durability and safety. The upgraded encoder and golden accents add premium refinement, and a massive 6000mAh battery ensures up to 150 days of use (4hr/day, RGB off) or 8 days with RGB, making it ideal for wireless enthusiasts.', 'm1_Black.jpg', 20),
('S031', 'P007', 'Silver', 399, 'The MonsGeek M1W Wireless Aluminum Keyboard Barebone delivers ultimate versatility with tri-mode connectivity (2.4GHz, Bluetooth, USB-C), a south-facing PCB for Cherry keycap compatibility, and vibrant RGB backlighting (20+ presets, 16M colors via Cloud Driver). Enhanced typing acoustics come from PORON plate foam, a flexible polycarbonate plate, and plate-mounted stabilizers, while a 3mm PORON case foam upgrade and VHB insulation layer improve durability and safety. The upgraded encoder and golden accents add premium refinement, and a massive 6000mAh battery ensures up to 150 days of use (4hr/day, RGB off) or 8 days with RGB, making it ideal for wireless enthusiasts.', 'm1_Silver.png', 20),
('S032', 'P007', 'Purple', 399, 'The MonsGeek M1W Wireless Aluminum Keyboard Barebone delivers ultimate versatility with tri-mode connectivity (2.4GHz, Bluetooth, USB-C), a south-facing PCB for Cherry keycap compatibility, and vibrant RGB backlighting (20+ presets, 16M colors via Cloud Driver). Enhanced typing acoustics come from PORON plate foam, a flexible polycarbonate plate, and plate-mounted stabilizers, while a 3mm PORON case foam upgrade and VHB insulation layer improve durability and safety. The upgraded encoder and golden accents add premium refinement, and a massive 6000mAh battery ensures up to 150 days of use (4hr/day, RGB off) or 8 days with RGB, making it ideal for wireless enthusiasts.', 'm1_Purple.jpg', 10),
('S033', 'P008', 'Keycaps CSGO Themed', 230, 'This 130+ keycap set offers extensive compatibility, covering 40% to 100% layouts, including Planck, GH60, Tada68, and more. Made from high-quality PBT with a dye-sublimated design, the keycaps resist fading and provide a durable, oil-resistant matte texture. The XDA profile ensures uniform height for ergonomic comfort and broad layout support, fitting Cherry MX, Gateron, Kailh, and TTC switches.', 'keycapscsgo.jpg', 15),
('S034', 'P009', 'Razer Basilisk V3', 368.53, 'Razer Basilisk V3 is the wired-only model featuring Razer\'s Focus+ 26K DPI optical sensor capable of tracking at speeds up to 650 IPS with 50G acceleration. It uses durable 2nd-gen optical mouse switches rated for 70 million clicks and connects via Razer\'s flexible Speedflex cable. The mouse measures 130×75×42.5mm and weighs 101g, offering 11 programmable buttons and customizable RGB lighting in an ergonomic right-handed design.', 'razer-basilisk-v3.png', 25),
('S035', 'P009', 'Razer Basilisk V3 X Hyperspeed', 417.5, 'Razer Basilisk V3 X HyperSpeed is the wireless budget option with dual connectivity (Bluetooth and HyperSpeed wireless) using Razer\'s 5G Advanced 18K DPI sensor (450 IPS/40G). It features mechanical switches rated for 60 million clicks and omits RGB lighting to extend battery life. Slightly larger at 130.1×75.1×42.5mm and heavier at 110g, it maintains the Basilisk\'s signature shape while being more portable without a cable.', 'razer-basilisk-v3-x-hyperspeed.png', 40),
('S036', 'P009', 'Razer Basilisk V3 Pro', 976.42, 'Razer Basilisk V3 Pro stands as the premium flagship with tri-mode connectivity (HyperSpeed, Bluetooth, and USB-C wired). Its cutting-edge Focus Pro 30K DPI sensor achieves 750 IPS tracking and 70G acceleration, paired with 3rd-gen optical switches rated for 90 million clicks. At 130×75.4×42.5mm and 112g, it adds wireless Qi charging support while keeping all the V3\'s features including RGB lighting and 11 programmable buttons, making it the most versatile and high-performance option in the lineup.', 'razer-basilisk-v3-pro.png', 50),
('S037', 'P010', 'Harman Kardon Aura Studio 4', 1299, 'The Harman Kardon Aura Studio 4 is a high-end Bluetooth speaker that merges iconic design with exceptional audio quality, featuring Bluetooth 4.2 (0–9 dBm power, 2.402–2.480 GHz range) with A2DP 1.3/AVRCP 1.6 support for seamless wireless streaming. Its robust 6-driver array (six 40mm mid-high transducers + one 130mm subwoofer) delivers 2x15W RMS for mids/highs and 100W RMS for bass, producing a wide 45Hz–20kHz (-6dB) frequency range with an 80dB signal-to-noise ratio for crisp, distortion-free sound. Housed in a signature transparent dome, the speaker measures 283.6 x 232 x 232mm (11.2\" x 9.1\" x 9.1\") and weighs 3.6kg (7.9lb), powered by a universal 100–240V ~ 50/60Hz supply. Combining immersive audio with avant-garde aesthetics, the Aura Studio 4 excels as both a premium sound system and a statement piece.', 'harmankardon1.jpg', 30),
('S038', 'P011', 'Black', 1199, 'The Edifier QD35 is a premium desktop speaker system that blends cutting-edge audio technology with sleek design, featuring a quality housing enclosure with quadratic elements to minimize acoustic resonance for purer sound. It delivers 40W RMS power (25W mid-bass + 15W treble) through its 3-inch mid-bass and 1-inch tweeter drivers, covering a wide frequency response of 60Hz–40kHz for detailed highs and punchy lows, certified for both Hi-Res Audio and Hi-Res Wireless (up to 96kHz). Connectivity options include Bluetooth 5.3 (10m range), USB-A, and AUX-in, while the Edifier Connect app allows customization of EQ settings and LED colors. The system also features ultra-fast 35W GaN charging for devices and boasts a signal-to-noise ratio ≥85dB(A) for crystal-clear audio. Compact yet powerful, it measures 277.8 × 164.8 × 141.7mm and weighs 2.64kg, making it an ideal blend of performance, versatility, and modern aesthetics for discerning listeners.', 'qd35_black.png', 35),
('S039', 'P011', 'White', 1199, 'The Edifier QD35 is a premium desktop speaker system that blends cutting-edge audio technology with sleek design, featuring a quality housing enclosure with quadratic elements to minimize acoustic resonance for purer sound. It delivers 40W RMS power (25W mid-bass + 15W treble) through its 3-inch mid-bass and 1-inch tweeter drivers, covering a wide frequency response of 60Hz–40kHz for detailed highs and punchy lows, certified for both Hi-Res Audio and Hi-Res Wireless (up to 96kHz). Connectivity options include Bluetooth 5.3 (10m range), USB-A, and AUX-in, while the Edifier Connect app allows customization of EQ settings and LED colors. The system also features ultra-fast 35W GaN charging for devices and boasts a signal-to-noise ratio ≥85dB(A) for crystal-clear audio. Compact yet powerful, it measures 277.8 × 164.8 × 141.7mm and weighs 2.64kg, making it an ideal blend of performance, versatility, and modern aesthetics for discerning listeners.', 'qd35_white.jpg', 20),
('S040', 'P012', 'V2 Pro', 1055.96, 'The BlackShark V2 Pro is a premium wireless gaming headset featuring Razer™ TriForce Titanium 50mm drivers with a 12Hz–28kHz frequency response, delivering crisp highs and deep lows. It offers THX Spatial Audio for immersive 7.1 surround sound and connects via 2.4GHz wireless (Type-A dongle) or Bluetooth 5.2, with up to 70 hours of battery life. The 32Ω impedance and 100dB sensitivity ensure powerful audio, while its oval ear cushions with pressure-relieving memory foam provide long-wearing comfort. The detachable Super Wideband mic (-42dB sensitivity, 100Hz–10kHz range) ensures clear comms, and its 320g weight balances durability with comfort. Compatible with PC, PlayStation, and mobile devices.', 'v2_pro.jpg', 30),
('S041', 'P012', 'V2 Hyperspeed', 533.07, 'The BlackShark V2 HyperSpeed is a versatile wireless headset with custom 50mm drivers (20Hz–20kHz range) and THX Spatial Audio for precise positional sound. It supports dual connectivity (2.4GHz wireless or Bluetooth) and has a 32Ω impedance with 96dB sensitivity. The breathable memory foam ear cushions enhance comfort, while the Razer™ HyperClear Super Wideband mic (-42dB sensitivity) delivers studio-quality voice capture. Weighing 280g, it’s lighter than the V2 Pro but lacks battery specs as it’s wired-optional. Works with PC, PlayStation, and mobile devices via USB or Bluetooth.', 'v2_hyperspeed.jpg', 40),
('S042', 'P012', 'V2 X USB', 301.24, 'The BlackShark V2 X USB is a wired USB headset with Razer™ TriForce 50mm drivers (12Hz–28kHz range) and 7.1 surround sound (Windows 10+ only). Its 32Ω impedance and 100dB sensitivity ensure loud, clear audio, while the hybrid memory foam ear cushions offer comfort during extended use. The non-detachable Razer™ HyperClear Cardioid mic (-42dB sensitivity) focuses on voice clarity. Weighing 240g, it connects via USB Type-A (2.0m cable) and is compatible with PC, Mac, PS4, Xbox One, and mobile devices.', 'v2_x_usb.jpg', 50),
('S043', 'P012', 'V2 X', 172.45, 'The BlackShark V2 X is an affordable wired analog headset with custom 50mm drivers (20Hz–20kHz range) and passive noise cancellation. Its 32Ω impedance and 96dB sensitivity provide balanced sound, paired with breathable memory foam ear cushions. The fixed Razer™ HyperClear Noise-Cancelling mic (-42dB sensitivity) ensures clear voice pickup. Lightweight at 240g, it uses a 3.5mm analog jack (1.3m cable) and works with PC, consoles, and mobile devices. Lacks surround sound but remains a budget-friendly option for competitive gaming.', 'v2_x.jpg', 35),
('S044', 'P013', 'Black and Brass', 959, 'The Marshall Emberton II is a compact yet powerful Bluetooth speaker featuring two 2-inch 10W full-range drivers and dual passive radiators for rich stereo sound across a 60Hz-20kHz frequency range. With two Class D amplifiers, it delivers a maximum SPL of 87dB for room-filling audio. The rugged IP67-rated design measures 68 x 160 x 76mm (2.68 x 6.30 x 2.99in) and weighs just 0.7kg, making it highly portable. Its built-in Li-ion battery provides 30+ hours playtime, supports quick charging (4 hours playback from 20 minutes charge), and fully recharges in 3 hours. The Emberton II combines Marshall\'s signature sound with durable, water/dust-proof construction for versatile indoor/outdoor use.', 'marshall-black.jpg', 25),
('S045', 'P013', 'Cream', 959, 'The Marshall Emberton II is a compact yet powerful Bluetooth speaker featuring two 2-inch 10W full-range drivers and dual passive radiators for rich stereo sound across a 60Hz-20kHz frequency range. With two Class D amplifiers, it delivers a maximum SPL of 87dB for room-filling audio. The rugged IP67-rated design measures 68 x 160 x 76mm (2.68 x 6.30 x 2.99in) and weighs just 0.7kg, making it highly portable. Its built-in Li-ion battery provides 30+ hours playtime, supports quick charging (4 hours playback from 20 minutes charge), and fully recharges in 3 hours. The Emberton II combines Marshall\'s signature sound with durable, water/dust-proof construction for versatile indoor/outdoor use.', 'marshall-cream.jpg', 30),
('S046', 'P014', 'Prism + X270 PRO', 1099, 'The X270 PRO is a 27-inch curved gaming monitor with a 1500R curvature, offering an immersive QHD (2560 x 1440) resolution at a smooth 165Hz refresh rate—ideal for fast-paced gaming with AMD FreeSync support to eliminate screen tearing. Its VA panel delivers vibrant colors with 120% sRGB coverage, 3000:1 contrast ratio, and HDR400 for enhanced brightness (up to 400 cd/m²). With a 4ms GTG / 1ms MPRT response time, it ensures sharp motion clarity, while 178° viewing angles maintain image consistency. The monitor features tilt adjustment and VESA 75x75mm mounting but lacks height/swivel adjustments. Connectivity includes 2x HDMI 2.0 and 2x DisplayPort 1.4, alongside flicker-free and low blue light technologies for reduced eye strain. Weighing 5.9kg with its stand (5.15kg without), it has a sleek footprint (616mm width, 450mm height, 195.7mm depth) and comes with a 3-year warranty. No built-in speakers, but an audio-out port allows external audio setups. A premium choice for gamers seeking curvature, speed, and visual fidelity.', 'x270.jpg', 35),
('S047', 'P015', 'Phantom', 290, 'The Royal Kludge M75 is a premium 75% wireless mechanical keyboard featuring a gasket-mounted design for superior typing comfort and sound, with tri-mode connectivity (USB-C/2.4GHz/Bluetooth 5.1) and a 3750mAh battery. Its standout OLED display and rotary knob enable real-time adjustments for volume, device switching, and system settings, while hot-swappable switches (Fast Silver, Viridian, or Pale Green) and Cherry-profile PBT keycaps offer customizable tactile experiences. The south-facing RGB backlighting ensures vibrant illumination without switch interference, and the compact 81-key layout retains functionality while saving space. With low-latency wireless, multi-device pairing, and Windows/Mac compatibility, the RK M75 excels for both gaming and productivity in a sleek, portable form.', 'm75_phantom.png', 20),
('S048', 'P015', 'Ocean Blue', 290, 'The Royal Kludge M75 is a premium 75% wireless mechanical keyboard featuring a gasket-mounted design for superior typing comfort and sound, with tri-mode connectivity (USB-C/2.4GHz/Bluetooth 5.1) and a 3750mAh battery. Its standout OLED display and rotary knob enable real-time adjustments for volume, device switching, and system settings, while hot-swappable switches (Fast Silver, Viridian, or Pale Green) and Cherry-profile PBT keycaps offer customizable tactile experiences. The south-facing RGB backlighting ensures vibrant illumination without switch interference, and the compact 81-key layout retains functionality while saving space. With low-latency wireless, multi-device pairing, and Windows/Mac compatibility, the RK M75 excels for both gaming and productivity in a sleek, portable form.', 'm75_oceanBlue.jpg', 15),
('S049', 'P015', 'Taro Milk', 290, 'The Royal Kludge M75 is a premium 75% wireless mechanical keyboard featuring a gasket-mounted design for superior typing comfort and sound, with tri-mode connectivity (USB-C/2.4GHz/Bluetooth 5.1) and a 3750mAh battery. Its standout OLED display and rotary knob enable real-time adjustments for volume, device switching, and system settings, while hot-swappable switches (Fast Silver, Viridian, or Pale Green) and Cherry-profile PBT keycaps offer customizable tactile experiences. The south-facing RGB backlighting ensures vibrant illumination without switch interference, and the compact 81-key layout retains functionality while saving space. With low-latency wireless, multi-device pairing, and Windows/Mac compatibility, the RK M75 excels for both gaming and productivity in a sleek, portable form.', 'm75_taroMilk.jpg', 40),
('S050', 'P016', '500GB', 265, 'The SanDisk Extreme Pro XS2000 External SSD delivers blazing-fast 2,000MB/s read and write speeds via USB 3.2 Gen 2x2 in a compact, durable metal-plastic casing (69.54 x 32.58 x 13.5mm, 28.9g). Ideal for professionals and gamers, it includes a protective rubber sleeve and 12” USB-C to USB-C cable, supporting Windows, macOS, Linux, Chrome OS, Android, iOS/iPadOS (v13+), and consoles. With an operating range of 0°C–40°C, it balances high performance with broad compatibility in a pocket-sized design.', 'XS2000.jpg', 60),
('S051', 'P016', '1TB', 412, 'The SanDisk Extreme Pro XS2000 External SSD delivers blazing-fast 2,000MB/s read and write speeds via USB 3.2 Gen 2x2 in a compact, durable metal-plastic casing (69.54 x 32.58 x 13.5mm, 28.9g). Ideal for professionals and gamers, it includes a protective rubber sleeve and 12” USB-C to USB-C cable, supporting Windows, macOS, Linux, Chrome OS, Android, iOS/iPadOS (v13+), and consoles. With an operating range of 0°C–40°C, it balances high performance with broad compatibility in a pocket-sized design.', 'XS2000.jpg', 70),
('S052', 'P016', '2TB', 698, 'The SanDisk Extreme Pro XS2000 External SSD delivers blazing-fast 2,000MB/s read and write speeds via USB 3.2 Gen 2x2 in a compact, durable metal-plastic casing (69.54 x 32.58 x 13.5mm, 28.9g). Ideal for professionals and gamers, it includes a protective rubber sleeve and 12” USB-C to USB-C cable, supporting Windows, macOS, Linux, Chrome OS, Android, iOS/iPadOS (v13+), and consoles. With an operating range of 0°C–40°C, it balances high performance with broad compatibility in a pocket-sized design.', 'XS2000.jpg', 90),
('S053', 'P016', '4TB', 1358, 'The SanDisk Extreme Pro XS2000 External SSD delivers blazing-fast 2,000MB/s read and write speeds via USB 3.2 Gen 2x2 in a compact, durable metal-plastic casing (69.54 x 32.58 x 13.5mm, 28.9g). Ideal for professionals and gamers, it includes a protective rubber sleeve and 12” USB-C to USB-C cable, supporting Windows, macOS, Linux, Chrome OS, Android, iOS/iPadOS (v13+), and consoles. With an operating range of 0°C–40°C, it balances high performance with broad compatibility in a pocket-sized design.', 'XS2000.jpg', 50);

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` varchar(100) NOT NULL,
  `expire` datetime NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `expire`, `email`) VALUES
('e0786a0788f81f0bddab1ad81ca183facf839f93', '2025-05-07 07:44:16', 'giggsttw-pm18@student.tarc.edu.my'),
('b35b747a063d8968acd255f42b6050827e3eb4ad', '2025-05-07 07:44:27', 'giggsttw-pm18@student.tarc.edu.my'),
('8a37672b88be7520f1841eddc693326eff54d6fd', '2025-05-07 07:45:42', 'giggsttw-pm18@student.tarc.edu.my'),
('41160a302d22c61cd0442f58f672d4c642707d99', '2025-05-07 07:48:24', 'giggsttw-pm18@student.tarc.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserFullName` varchar(100) NOT NULL,
  `Username` varchar(15) NOT NULL,
  `PhoneNo` int(11) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Pass` varchar(100) NOT NULL,
  `ProfilePic` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Roles` varchar(5) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserFullName`, `Username`, `PhoneNo`, `Email`, `Pass`, `ProfilePic`, `Address`, `Roles`) VALUES
('Admin', 'Admin', 1111111113, 'admin@gmail.com', 'c4dc25763bbcbb8b0ae7aa4bbffb400397850201', '', '', 'Admin'),
('aaaaa', 'ccn', 1222222289, 'ccn@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '', '-', 'User'),
('Nelson', 'Nelson', 1111111112, 'demo@gmail.com', 'c4dc25763bbcbb8b0ae7aa4bbffb400397850201', '', '', 'User'),
('Giggs Teh', 'GiggsStudent', 142255358, 'giggsttw-pm18@student.tarc.edu.my', '61d6504733ca7757e259c644acd085c4dd471019', '', '', 'User'),
('Nelson Cheng Ming Jian', 'Nelson', 182284609, 'nelsonchengmingjian@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'profilePic/681a10bc20112_rose-1.jpg', '-', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `Email` (`Email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`SpecID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD KEY `email` (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `user` (`Email`);

--
-- Constraints for table `specification`
--
ALTER TABLE `specification`
  ADD CONSTRAINT `specification_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
