-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 04:07 PM
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
(0, 'nelsonchengmingjian@gmail.com', 'S006,S009,S013,S002,S007,S001,S003,S004', '14,1,1,1,2,1,1,1', 'Purchased'),
(1, 'ccn@gmail.com', 'S011,S005,S020,S037', '466,1,1,1', 'InCart'),
(3, 'demo1@gmail.com', 'S019', '1', 'Purchased'),
(5, 'demo1@gmail.com', 'S012', '1', 'Purchased');

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
  `ProductPhoto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`SpecID`, `ProductID`, `Specification`, `Price`, `Descr`, `ProductPhoto`) VALUES
('S001', 'P001', 'INTEL i9-13900F', 2456.63, 'The Intel i9-13900F CPU features 24 cores, consisting of 8 performance cores and 16 efficient cores, providing a total of 32 threads with a maximum turbo frequency of 5.60 GHz. It operates with a base power of 65W and can reach a maximum turbo power of 219W, while offering a 36 MB cache. The CPU supports up to 192 GB of memory, compatible with DDR4 (up to 3200 MT/s) and DDR5 (up to 5600 MT/s) memory types, delivering a memory bandwidth of 89.6 GB/s. It does not have integrated graphics, requiring a separate discrete GPU for graphical tasks. The processor is housed in an FCLGA1700 socket, with a package size of 45.0 mm by 37.5 mm.', 'i9-13900F.jpg'),
('S002', 'P001', 'INTEL i9-13900KF', 2517.14, 'The Intel i9-13900KF CPU is equipped with 24 cores, consisting of 8 performance cores and 16 efficient cores, resulting in a total of 32 threads. It has a maximum turbo frequency of 5.80 GHz and operates with a base power of 125W, with a maximum turbo power of 253W. The processor features a 36 MB cache. It supports a maximum memory size of 192 GB and is compatible with DDR4 memory (up to 3200 MT/s) and DDR5 memory (up to 5600 MT/s), offering a memory bandwidth of 89.6 GB/s. This CPU does not have integrated graphics, meaning it requires a discrete GPU. The processor uses an FCLGA1700 socket and has a package size of 45.0 mm by 37.5 mm.', 'i9-13900KF.jpg'),
('S003', 'P001', 'INTEL i9-13900', 2578.08, 'The Intel i9-13900 CPU features 24 cores, consisting of 8 performance cores and 16 efficient cores, resulting in a total of 32 threads. It boasts a maximum turbo frequency of 5.60 GHz, with a processor base power of 65W and a maximum turbo power of 219W. The CPU is equipped with a 36 MB cache. It supports a maximum memory size of 192 GB and is compatible with both DDR4 memory (up to 3200 MT/s) and DDR5 memory (up to 5600 MT/s), offering a memory bandwidth of 89.6 GB/s. For integrated graphics, the i9-13900 features Intel® UHD Graphics 770 with 32 execution units. It supports various resolutions, including 4096 × 2160 at 60Hz via HDMI, 7680 × 4320 at 60Hz via DisplayPort, and 5120 × 3200 at 120Hz via eDP. The processor uses an FCLGA1700 socket and has a package size of 45.0 mm × 37.5 mm.', 'i9-13900.jpg'),
('S004', 'P001', 'INTEL i9-13900K', 2587.45, 'The Intel i9-13900K is a high-performance CPU with 24 cores, consisting of 8 performance cores and 16 efficient cores, delivering a total of 32 threads. It features a maximum turbo frequency of 5.80 GHz, a processor base power of 125W, and a maximum turbo power of 253W. The CPU is equipped with a 36 MB cache. It supports a maximum memory size of 192 GB and is compatible with both DDR4 memory (up to 3200 MT/s) and DDR5 memory (up to 5600 MT/s), offering a memory bandwidth of 89.6 GB/s. The i9-13900K comes with integrated Intel® UHD Graphics 770, consisting of 32 execution units, and supports a variety of resolutions, including 4096 × 2160 at 60Hz via HDMI, 7680 × 4320 at 60Hz via DisplayPort, and 5120 × 3200 at 120Hz via eDP. This processor uses an FCLGA1700 socket and has a package size of 45.0 mm × 37.5 mm.', 'i9-13900K.jpg'),
('S005', 'P001', 'INTEL i9-13900KS', 3281.2, 'The Intel i9-13900KS is a high-end CPU with 24 cores, including 8 performance cores and 16 efficient cores, providing a total of 32 threads. It boasts an impressive maximum turbo frequency of 6.00 GHz, with a base power of 150W and a maximum turbo power of 253W. The CPU has a 36 MB cache. It supports up to 192 GB of memory, compatible with DDR4 (up to 3200 MT/s) and DDR5 (up to 5600 MT/s) memory types, and offers a maximum memory bandwidth of 89.6 GB/s. The i9-13900KS comes with integrated Intel® UHD Graphics 770, featuring 32 execution units. It supports high-resolution outputs with HDMI at 4096 × 2160 at 60Hz, DisplayPort at 7680 × 4320 at 60Hz, and eDP at 5120 × 3200 at 120Hz. The CPU uses the FCLGA1700 socket and has a package size of 45.0 mm × 37.5 mm.', 'i9-13900KS.jpg'),
('S006', 'P002', 'AMD RYZEN 9 7900', 1920.35, 'The AMD R9 7900 processor comes with 12 cores and 24 threads, featuring an L1 cache of 768 KB, an L2 cache of 12 MB, and an L3 cache of 64 MB. It operates at a base frequency of 3.75 GHz and can boost up to 5.40 GHz, with a base power consumption of 65 W. In terms of memory, it supports a maximum of 128 GB across two channels, with compatibility for DDR5 memory at speeds of up to 5200 MT/s. For graphics, it includes AMD Radeon™ Graphics with 2 cores running at a frequency of 2200 MHz. Additionally, the processor is designed for the AM5 socket.', 'ryzen_9_7900.jpg'),
('S007', 'P002', 'AMD RYZEN 9 7900X', 2565.2, 'The AMD Ryzen 9 7900X is a powerful processor with a total of 12 cores and 24 threads, designed to deliver high performance. It features an L1 cache of 768 KB, an L2 cache of 12 MB, and a large L3 cache of 64 MB, making it well-suited for demanding tasks. The CPU operates at a base frequency of 4.70 GHz, with a maximum turbo frequency of 5.60 GHz, offering exceptional speed for intensive applications. The processor has a base power consumption of 170W. It supports up to 128 GB of memory with a dual-channel configuration and can handle DDR5 memory running at speeds up to 5200 MT/s. For integrated graphics, the Ryzen 9 7900X comes with AMD Radeon™ Graphics, equipped with 2 graphics cores running at a frequency of 2200 MHz. The processor uses the AM5 socket, making it compatible with a wide range of modern motherboards.', 'ryzen_9_7900X.jpg'),
('S008', 'P002', 'AMD RYZEN 9 7900X3D', 3266.08, 'The AMD Ryzen 9 7900X3D is a high-performance processor with 12 cores and 24 threads, ideal for demanding computing tasks. It features an L1 cache of 768 KB, an L2 cache of 12 MB, and a sizable L3 cache of 64 MB, ensuring fast data access for intensive applications. The processor has a base frequency of 4.40 GHz, with a max turbo frequency of 5.60 GHz, providing excellent performance during heavy workloads. With a base power consumption of 120W, it offers a balance of power efficiency and performance. The Ryzen 9 7900X3D supports up to 128 GB of memory, operating in a dual-channel configuration, and is compatible with DDR5 memory running at speeds up to 5200 MT/s. For integrated graphics, it includes AMD Radeon™ Graphics with 2 graphics cores, running at a frequency of 2200 MHz. This processor uses the AM5 socket, ensuring compatibility with modern motherboards.', 'ryzen_9_7900X3D.jpg'),
('S009', 'P002', 'AMD RYZEN 9 7950X', 3266.08, 'The AMD Ryzen 9 7950X is a high-performance processor designed for demanding applications, featuring 16 cores and 32 threads. It offers a solid L1 cache of 1 MB, an L2 cache of 16 MB, and a large L3 cache of 64 MB for quick access to data. Operating at a base frequency of 4.00 GHz, it can boost up to 5.70 GHz for maximum performance under heavy workloads. With a base power consumption of 170 W, it balances efficiency and power. The Ryzen 9 7950X supports up to 128 GB of memory across two channels, and it is compatible with high-speed DDR5 memory running up to 5200 MT/s. The processor also includes integrated AMD Radeon™ Graphics, with 2 graphics cores running at 2200 MHz. It is designed to fit the AM5 socket, ensuring compatibility with the latest motherboard designs.', 'ryzen_9_7950X.jpg'),
('S010', 'P002', 'AMD RYZEN 9 7950X3D', 3266.08, 'The AMD Ryzen 9 7950X3D is a high-end processor designed for demanding tasks, equipped with 16 cores and 32 threads. It boasts an L1 cache of 1 MB, an L2 cache of 16 MB, and a massive L3 cache of 128 MB, allowing for faster data access and enhanced performance. With a base frequency of 4.00 GHz and a maximum turbo frequency of 5.70 GHz, it can handle intensive workloads with ease. The processor has a base power consumption of 120 W, making it energy-efficient while delivering high performance. It supports up to 128 GB of memory across two channels, with compatibility for DDR5 memory running at speeds of up to 5200 MT/s. The Ryzen 9 7950X3D also integrates AMD Radeon™ Graphics, featuring 2 graphics cores with a frequency of 2200 MHz. This processor is designed to fit the AM5 socket, ensuring compatibility with the latest motherboards.', 'ryzen_9_7950X3D.jpg'),
('S011', 'P003', 'GeForce RTX 4060Ti', 1862.33, 'The GeForce RTX 4060 Ti features 4,352 NVIDIA CUDA® Cores with a base clock of 2.31 GHz and a boost clock of 2.54 GHz. It is available with either 8 GB or 16 GB of GDDR6 memory and uses a 128-bit memory interface. The GPU supports resolutions up to 4K at 240Hz or 8K at 60Hz with DSC and HDR, and includes standard display connectors such as HDMI and three DisplayPorts. It supports up to four monitors and includes HDCP 2.3 support. In terms of physical dimensions, the card is 244 mm in length, 98 mm in width, and occupies two slots. Thermally, the GPU can reach a maximum temperature of 90°C, with an average gaming power consumption of 140W and a total graphics power of 165W (or 160W for some variants), requiring a system power supply of at least 550W. Power is delivered via a single PCIe 8-pin cable, or optionally via a 300W or greater PCIe Gen 5 cable, with adapters included in the box for compatibility.', 'RTX4060Ti.jpg'),
('S012', 'P003', 'GeForce RTX 4070', 2795.83, 'The GeForce RTX 4070 is equipped with 5,888 NVIDIA CUDA® Cores, offering a base clock speed of 1.92 GHz and a boost clock of 2.48 GHz. It comes with 12 GB of GDDR6X memory and a 192-bit memory interface, delivering high-speed performance for demanding applications. The GPU supports a maximum resolution of 4K at 240Hz or 8K at 60Hz with DSC and HDR, and is fitted with standard display outputs including HDMI and three DisplayPorts. It supports up to four simultaneous displays and includes HDCP 2.3 support. The card measures 244 mm in length and 112 mm in width, occupying two slots in a PC case. It has a maximum GPU temperature of 90°C, with an average gaming power draw of 186W and a total graphics power of 200W, requiring a minimum system power of 650W. Power can be supplied through two PCIe 8-pin cables or a 300W or greater PCIe Gen 5 cable, with an adapter included for convenience.', 'RTX4070.jpg'),
('S013', 'P003', 'GeForce RTX 4080', 5596.33, 'The GeForce RTX 4080 features 9,728 NVIDIA CUDA® Cores, with a base clock speed of 2.21 GHz and a boost clock of 2.51 GHz. It is equipped with 16 GB of ultra-fast GDDR6X memory and a 256-bit memory interface, offering excellent bandwidth for high-resolution gaming and intensive workloads. This GPU supports a maximum resolution of 4K at 240Hz or 8K at 60Hz using DSC and HDR, and includes HDMI and three DisplayPort connectors for versatile display options. It supports up to four monitors and is HDCP 2.3 compliant. Measuring 304 mm in length and 137 mm in width, the card takes up three slots. It maintains a maximum operating temperature of 90°C, with an average gaming power consumption of 251W and a total graphics power of 320W. The recommended system power supply is 750W. Power can be delivered through three PCIe 8-pin cables (adapter included) or a single 450W or greater PCIe Gen 5 cable.', 'RTX4080.jpg'),
('S014', 'P003', 'GeForce RTX 4090', 7463.33, 'The GeForce RTX 4090 boasts 16,384 NVIDIA CUDA® Cores, a base clock speed of 2.23 GHz, and a boost clock of 2.52 GHz. This powerhouse comes with a massive 24 GB of GDDR6X memory and a 384-bit memory interface, ensuring exceptional performance for 4K gaming and demanding applications. It supports a maximum resolution of 4K at 240Hz or 8K at 60Hz using DSC and HDR, with HDMI and three DisplayPort connectors, allowing for up to four monitors. The card is HDCP 2.3 compliant. With dimensions of 304 mm in length and 137 mm in width, it occupies three slots in the system. The maximum GPU temperature is 90°C, and the average gaming power consumption is 315W, with a total graphics power of 450W. The recommended system power is 850W. Power connectors required include three PCIe 8-pin cables (adapter included) or a single 450W or greater PCIe Gen 5 cable.', 'RTX4090.jpeg'),
('S015', 'P004', 'Beast DDR5 (8GB)', 315, 'The Beast DDR5 8GB module is a UDIMM form factor memory stick, certified for both Intel XMP and AMD EXPO, providing Plug N Play functionality for easy setup. It operates at a speed of 4800 MHz with a CAS latency of 40 and a voltage of 1.1V. The module has a capacity of 8GB and is available in kit capacities of 16GB and 32GB, supporting both single and dual-channel configurations, but does not support quad-channel kits. The module\'s height without RGB is 34.9mm, and it comes with a lifetime warranty.', 'beastddr5.jpg'),
('S016', 'P004', 'Beast DDR5 RGB (8GB)', 329, 'The Beast DDR5 8GB module is a UDIMM form factor memory stick, certified for both Intel XMP and AMD EXPO, providing Plug N Play functionality for easy setup. It operates at a speed of 4800 MHz with a CAS latency of 40 and a voltage of 1.1V. The module has a capacity of 8GB and is available in kit capacities of 16GB and 32GB, supporting both single and dual-channel configurations, but does not support quad-channel kits. The module\'s height without RGB is 34.9mm, and it comes with a lifetime warranty.', 'beastddr5rgb.jpg'),
('S017', 'P004', 'Renegade DDR5 (16GB)', 359, 'The Renegade DDR5 16GB module is available in a UDIMM form factor and is Intel XMP certified, but not AMD EXPO certified. It also features Plug N Play functionality. It operates at a speed of 6000 MHz with a CAS latency of 32 and a voltage of 1.35V. The module\'s capacity is 16GB, and it is available in kit capacities ranging from 32GB to 64GB. It supports single and dual-channel kits but does not support quad or octal channel kits. The height of the module without RGB is 39.2mm, and it comes with a lifetime warranty.', 'renegadeddr5.jpg'),
('S018', 'P004', 'Renegade DDR5 RGB (16GB)', 499, 'The Renegade DDR5 16GB module is available in a UDIMM form factor and is Intel XMP certified, but not AMD EXPO certified. It also features Plug N Play functionality. It operates at a speed of 6000 MHz with a CAS latency of 32 and a voltage of 1.35V. The module\'s capacity is 16GB, and it is available in kit capacities ranging from 32GB to 64GB. It supports single and dual-channel kits but does not support quad or octal channel kits. The height of the module without RGB is 39.2mm, and it comes with a lifetime warranty.', 'renegadeddr5rgb.jpg'),
('S019', 'P004', 'Renegade Pro (16GB)', 585, 'The Renegade Pro DDR5 16GB memory module is designed in UDIMM form factor, with Intel XMP certification but no AMD EXPO certification. It does not support Plug N Play functionality. The memory operates at a speed of 4800 MHz with a CAS latency of 36 and a voltage of 1.1V. The module capacity is 16GB, and the kit capacity is 64GB. It is available as single modules and dual-channel kits, but it does not offer quad-channel or octal-channel kits. The PCB color is black, and the heat spreader is also black. The height of the module is 31.25mm, and it comes with a lifetime warranty.', 'renegadepro.jpg'),
('S020', 'P004', 'Impact DDR5 (8GB)', 199, 'The Impact DDR5 memory module comes in a SODIMM form factor and is certified for Intel XMP but not for AMD EXPO. It supports Plug N Play functionality for easy use. The module operates at a speed of 4800 MHz with a CAS latency of 40 and a voltage of 1.1V. It has a module capacity of 8GB and is available in kit capacities of 16GB to 32GB. The module supports single modules and dual channel kits but does not support quad channel kits or octal channel kits. The PCB color is black, and the heat spreader color is also black. The module\'s height is 30mm, and it is backed by a lifetime warranty.', 'impactddr5.jpg'),
('S021', 'P005', 'Black', 289, 'The Leobog Hi75 Keyboard Kit offers a premium 75% keyboard experience with a sleek CNC Aluminium Body and a stylish Ruby Clear Knob. This kit is designed for a wired mode connection and features SOUTH FACING hot-swappable 5-pin switches, allowing for easy customization. It includes prelubed plate mounted stabilizers, a Polypropylene (PP) plate, and a Poron gasket, ensuring a smooth and responsive typing experience. The keyboard also comes with Poron plate foam, Poron case foam, and an IXPE switch pad to enhance acoustics and feel. A detachable Type C cable ensures convenience, and the full RGB lighting adds a touch of personalization. The keyboard supports all-keys anti-ghosting, a 1000Hz polling rate, and is compatible with both Windows and Mac systems. The kit also provides Leobog software support and is easy to use with a simple plug-and-play setup. In the box, you\'ll find the Leobog Hi75 Keyboard Kit, a Type A to Type C coiled cable, two Leobog switches, and a user manual.', 'hi75.png,hi752.jpg,hi753.jpg,hi754.jpg,hi755.jpg'),
('S022', 'P005', 'Blue', 289, 'The Leobog Hi75 Keyboard Kit offers a premium 75% keyboard experience with a sleek CNC Aluminium Body and a stylish Ruby Clear Knob. This kit is designed for a wired mode connection and features SOUTH FACING hot-swappable 5-pin switches, allowing for easy customization. It includes prelubed plate mounted stabilizers, a Polypropylene (PP) plate, and a Poron gasket, ensuring a smooth and responsive typing experience. The keyboard also comes with Poron plate foam, Poron case foam, and an IXPE switch pad to enhance acoustics and feel. A detachable Type C cable ensures convenience, and the full RGB lighting adds a touch of personalization. The keyboard supports all-keys anti-ghosting, a 1000Hz polling rate, and is compatible with both Windows and Mac systems. The kit also provides Leobog software support and is easy to use with a simple plug-and-play setup. In the box, you\'ll find the Leobog Hi75 Keyboard Kit, a Type A to Type C coiled cable, two Leobog switches, and a user manual.', 'hi75.png,hi752.jpg,hi753.jpg,hi754.jpg,hi755.jpg'),
('S023', 'P005', 'Red', 289, 'The Leobog Hi75 Keyboard Kit offers a premium 75% keyboard experience with a sleek CNC Aluminium Body and a stylish Ruby Clear Knob. This kit is designed for a wired mode connection and features SOUTH FACING hot-swappable 5-pin switches, allowing for easy customization. It includes prelubed plate mounted stabilizers, a Polypropylene (PP) plate, and a Poron gasket, ensuring a smooth and responsive typing experience. The keyboard also comes with Poron plate foam, Poron case foam, and an IXPE switch pad to enhance acoustics and feel. A detachable Type C cable ensures convenience, and the full RGB lighting adds a touch of personalization. The keyboard supports all-keys anti-ghosting, a 1000Hz polling rate, and is compatible with both Windows and Mac systems. The kit also provides Leobog software support and is easy to use with a simple plug-and-play setup. In the box, you\'ll find the Leobog Hi75 Keyboard Kit, a Type A to Type C coiled cable, two Leobog switches, and a user manual.', 'hi75.png,hi752.jpg,hi753.jpg,hi754.jpg,hi755.jpg'),
('S024', 'P006', 'Brown Switch', 0.9, 'Keyboard', ''),
('S025', 'P006', 'Yellow Switch', 1, 'Keyboard', ''),
('S026', 'P006', 'Red Switch', 0.9, 'Keyboard', ''),
('S027', 'P006', 'Black Switch', 1.5, 'Keyboard', ''),
('S028', 'P006', 'White Switch', 1.4, 'Keyboard', ''),
('S029', 'P006', 'Silver Switch', 1.4, 'Keyboard', ''),
('S030', 'P007', 'MonsGeek M1W Barebone', 399, 'Black', ''),
('S031', 'P007', 'MonsGeek M1W Barebone', 399, 'Silver', ''),
('S032', 'P007', 'MonsGeek M1W Barebone', 399, 'Purple', ''),
('S033', 'P008', 'Keycaps CSGO Themed', 230, 'Keyboard', ''),
('S034', 'P009', 'Razer Basilisk V3', 368.53, 'Accessories', ''),
('S035', 'P009', 'Razer Basilisk V3 X Hyperspeed', 417.5, 'Accessories', ''),
('S036', 'P009', 'Razer Basilisk V3 Pro', 976.42, 'Accessories', ''),
('S037', 'P010', 'Harman Kardon Aura Studio 4', 1299, 'Accessories', ''),
('S038', 'P011', 'Black', 1199, 'Accessories', ''),
('S039', 'P011', 'White', 1199, 'Accessories', ''),
('S040', 'P012', 'V2 Pro', 1055.96, 'Accessories', ''),
('S041', 'P012', 'V2 Hyperspeed', 533.07, 'Accessories', ''),
('S042', 'P012', 'V2 X USB', 301.24, 'Accessories', ''),
('S043', 'P012', 'V2 X', 172.45, 'Accessories', ''),
('S044', 'P013', 'Black and Brass', 959, 'Accessories', ''),
('S045', 'P013', 'Cream', 959, 'Accessories', ''),
('S046', 'P014', 'Prism + X270 PRO', 1099, 'Accessories', ''),
('S047', 'P015', 'Phantom', 290, 'Keyboard', ''),
('S048', 'P015', 'Ocean Blue', 290, 'Keyboard', ''),
('S049', 'P015', 'Taro Milk', 290, 'Keyboard', ''),
('S050', 'P016', '500GB', 265, 'Accessories', ''),
('S051', 'P016', '1TB', 412, 'Accessories', ''),
('S052', 'P016', '2TB', 698, 'Accessories', ''),
('S053', 'P016', '4TB', 1358, 'Accessories', '');

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
('demo', 'demo', 1111111114, 'demo1@gmail.com', 'c4dc25763bbcbb8b0ae7aa4bbffb400397850201', '', '1-24-13, Halaman Krystal, Lengkok Free School', 'User'),
('Nelson', 'Nelson', 1111111112, 'demo@gmail.com', 'c4dc25763bbcbb8b0ae7aa4bbffb400397850201', '', '', 'User'),
('Nelson Cheng Ming Jian', 'Nelson1100', 182284609, 'nelsonchengmingjian@gmail.com', 'c4dc25763bbcbb8b0ae7aa4bbffb400397850201', 'profilePic/68049e7f6b310_switch.jpg', '1-24-13, Halaman Krystal, Lengkok Free School', 'User');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
