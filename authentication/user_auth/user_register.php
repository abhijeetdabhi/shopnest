<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="../../src/logo/favicon.svg">

    <!-- alpinejs CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex justify-center h-[100%] p-2 outfit">
    <div class="lg:w-[45%]">
        <!-- header -->
        <div class="p-2 flex items-center justify-center">
            <!-- icon logo div -->
            <div>
                <svg class="w-14 mb-2" id="svg" version="1.1" viewBox="0 0 235 245" xmlns="http://www.w3.org/2000/svg">
                    <path d="M206.892 29.517 C 200.010 35.658,189.576 41.188,180.534 43.486 C 177.253 44.321,174.020 45.565,173.350 46.251 C 171.971 47.664,166.551 67.884,167.340 68.673 C 168.204 69.537,179.069 65.995,179.498 64.708 C 179.720 64.044,180.387 61.601,180.981 59.280 C 181.959 55.459,182.459 54.955,186.280 53.935 C 192.663 52.233,206.793 44.596,213.175 39.399 C 220.155 33.714,221.953 30.104,219.596 26.506 C 217.004 22.551,213.866 23.295,206.892 29.517 M187.489 66.415 C 175.914 71.986,167.370 75.176,152.530 79.468 C 134.661 84.637,129.605 84.992,73.809 84.996 C 42.099 84.998,21.890 85.369,21.529 85.954 C 21.204 86.478,23.708 97.616,27.091 110.704 C 36.326 146.420,36.763 147.773,40.319 151.631 C 43.254 154.814,44.853 155.423,61.000 159.496 C 119.290 174.200,132.222 177.178,133.265 176.135 C 134.554 174.846,142.811 143.001,141.988 142.493 C 141.595 142.249,137.091 141.577,131.981 140.998 C 117.748 139.386,103.951 134.196,95.673 127.341 C 94.119 126.053,93.097 125.000,93.402 125.000 C 93.708 125.000,98.805 126.421,104.729 128.157 C 114.056 130.891,117.109 131.325,127.500 131.389 C 140.801 131.472,146.510 130.377,158.035 125.534 C 169.890 120.551,185.000 109.616,185.000 106.019 C 185.000 101.812,182.568 101.790,173.204 105.910 C 157.976 112.611,137.440 118.000,127.130 118.000 C 116.025 118.000,96.071 112.603,86.157 106.917 C 83.218 105.232,80.968 103.709,81.157 103.533 C 81.346 103.356,84.425 103.847,88.000 104.623 C 97.573 106.700,117.170 107.461,126.000 106.100 C 152.550 102.005,175.202 91.159,196.800 72.198 C 201.896 67.725,203.043 66.173,202.800 64.084 C 202.342 60.138,199.695 60.541,187.489 66.415 M153.500 139.345 L 149.500 140.537 144.185 162.000 C 141.262 173.805,138.727 183.607,138.551 183.782 C 138.375 183.958,133.117 182.801,126.866 181.212 C 39.403 158.976,38.030 158.663,35.961 160.535 C 33.692 162.589,33.370 167.232,35.381 168.901 C 36.994 170.240,36.192 170.024,90.000 183.580 C 112.825 189.331,132.287 194.283,133.250 194.585 C 139.517 196.553,130.805 197.000,86.155 197.000 C 40.105 197.000,37.215 197.105,35.655 198.829 C 33.484 201.228,33.555 204.287,35.829 206.345 C 37.479 207.838,42.519 208.000,87.428 208.000 C 147.299 208.000,144.085 208.664,147.666 195.546 C 150.099 186.630,161.000 140.651,161.000 139.303 C 161.000 137.736,158.860 137.749,153.500 139.345 M48.746 213.750 C 42.609 220.173,42.967 231.130,49.501 236.867 C 60.536 246.555,77.420 239.409,77.368 225.071 C 77.329 214.163,68.051 206.931,63.943 214.606 C 62.742 216.850,62.786 217.561,64.283 220.171 C 67.511 225.795,66.031 230.000,60.823 230.000 C 58.988 230.000,57.508 229.178,56.458 227.576 C 55.014 225.373,55.012 224.877,56.435 222.126 C 58.641 217.861,58.403 214.395,55.777 212.557 C 52.723 210.417,51.778 210.578,48.746 213.750 M106.353 212.465 C 101.454 215.897,99.367 226.942,102.480 232.961 C 104.448 236.767,108.397 239.760,113.131 241.035 C 123.049 243.706,134.000 235.291,134.000 225.000 C 134.000 218.879,128.916 211.000,124.966 211.000 C 120.764 211.000,118.603 217.569,121.532 221.441 C 123.502 224.045,123.381 226.345,121.171 228.345 C 118.340 230.907,114.173 230.473,112.806 227.474 C 111.880 225.441,111.982 224.261,113.327 221.440 C 115.492 216.900,115.435 215.435,113.000 213.000 C 110.618 210.618,109.158 210.501,106.353 212.465 " stroke="none" fill="black" fill-rule="evenodd" />
                </svg>
            </div>
            <!-- text logo -->
            <div>
                <svg class="w-40" viewBox="0 0 350 112.41287475877095" class="looka-1j8o68f">
                    <defs id="SvgjsDefs3842"></defs>
                    <g id="SvgjsG3843" featurekey="n48U4P-0" transform="matrix(3.877686263372148,0,0,3.877686263372148,-2.249130773395342,-22.18036276389283)" fill="#000000">
                        <path d="M5.32 9.38 c1.3867 0 2.47 0.28002 3.25 0.84002 s1.2167 1.38 1.31 2.46 l-2.7 0 c-0.04 -0.49334 -0.22 -0.85 -0.54 -1.07 s-0.78666 -0.33 -1.4 -0.33 c-0.53334 0 -0.93 0.08 -1.19 0.24 s-0.39 0.4 -0.39 0.72 c0 0.24 0.08666 0.44 0.26 0.6 s0.43668 0.3 0.79002 0.42 s0.74334 0.22 1.17 0.3 c1.2933 0.25334 2.2066 0.51334 2.74 0.78 s0.92334 0.58666 1.17 0.96 s0.37 0.83334 0.37 1.38 c0 1.16 -0.42334 2.05 -1.27 2.67 s-1.9967 0.93 -3.45 0.93 c-1.52 0 -2.7034 -0.32666 -3.55 -0.98 s-1.2833 -1.54 -1.31 -2.66 l2.7 0 c0 0.53334 0.20666 0.95668 0.62 1.27 s0.93334 0.47 1.56 0.47 c0.53334 0 0.97668 -0.11666 1.33 -0.35 s0.53 -0.55668 0.53 -0.97002 c0 -0.26666 -0.11 -0.48666 -0.33 -0.66 s-0.53 -0.32668 -0.93 -0.46002 s-1.02 -0.28668 -1.86 -0.46002 c-0.66666 -0.13334 -1.26 -0.31334 -1.78 -0.54 s-0.91666 -0.52332 -1.19 -0.88998 s-0.41 -0.81666 -0.41 -1.35 c0 -0.68 0.16334 -1.2733 0.49 -1.78 s0.82666 -0.89 1.5 -1.15 s1.51 -0.39 2.51 -0.39 z M14.66 5.720000000000001 l0 5.38 l0.06 0 c0.32 -0.53334 0.75334 -0.95334 1.3 -1.26 s1.1267 -0.46 1.74 -0.46 c1.32 0 2.2766 0.33334 2.87 1 s0.89 1.72 0.89 3.16 l0 6.46 l-2.84 0 l0 -5.88 c0 -0.84 -0.13666 -1.4667 -0.41 -1.88 s-0.74334 -0.62 -1.41 -0.62 c-0.76 0 -1.3167 0.23 -1.67 0.69 s-0.53 1.2167 -0.53 2.27 l0 5.42 l-2.84 0 l0 -14.28 l2.84 0 z M28.700000000000003 9.38 c1.6533 0 2.96 0.50334 3.92 1.51 s1.44 2.3234 1.44 3.95 c0 1.64 -0.49 2.9566 -1.47 3.95 s-2.2766 1.49 -3.89 1.49 c-1.64 0 -2.94 -0.50334 -3.9 -1.51 s-1.44 -2.3166 -1.44 -3.93 c0 -1.6667 0.49 -2.9934 1.47 -3.98 s2.27 -1.48 3.87 -1.48 z M26.200000000000003 14.84 c0 1.0533 0.21334 1.8666 0.64 2.44 s1.0467 0.86 1.86 0.86 c0.84 0 1.47 -0.29334 1.89 -0.88 s0.63 -1.3933 0.63 -2.42 c0 -1.0667 -0.21666 -1.8867 -0.65 -2.46 s-1.0633 -0.86 -1.89 -0.86 c-0.8 0 -1.4133 0.28666 -1.84 0.86 s-0.64 1.3933 -0.64 2.46 z M41.72 9.38 c1.4267 0 2.5666 0.5 3.42 1.5 s1.28 2.3534 1.28 4.06 c0 1.56 -0.41 2.84 -1.23 3.84 s-1.9233 1.5 -3.31 1.5 c-1.36 0 -2.3934 -0.52 -3.1 -1.56 l-0.04 0 l0 4.92 l-2.84 0 l0 -13.98 l2.7 0 l0 1.32 l0.04 0 c0.68 -1.0667 1.7067 -1.6 3.08 -1.6 z M38.64 14.86 c0 1.0133 0.21336 1.8133 0.64002 2.4 s1.04 0.88 1.84 0.88 c0.82666 0 1.4433 -0.29334 1.85 -0.88 s0.61 -1.3867 0.61 -2.4 c0 -1.04 -0.22 -1.8567 -0.66 -2.45 s-1.0533 -0.89 -1.84 -0.89 s-1.39 0.29334 -1.81 0.88 s-0.63 1.4067 -0.63 2.46 z M51.54 5.720000000000001 l5.96 9.58 l0.04 0 l0 -9.58 l2.94 0 l0 14.28 l-3.14 0 l-5.94 -9.56 l-0.04 0 l0 9.56 l-2.94 0 l0 -14.28 l3.12 0 z M67.72 9.38 c0.97334 0 1.84 0.22664 2.6 0.67998 s1.3567 1.11 1.79 1.97 s0.65 1.85 0.65 2.97 c0 0.10666 -0.0066602 0.28 -0.02 0.52 l-7.46 0 c0.02666 0.82666 0.24332 1.47 0.64998 1.93 s1.03 0.69 1.87 0.69 c0.52 0 0.99666 -0.13 1.43 -0.39 s0.71 -0.57666 0.83 -0.95 l2.5 0 c-0.73334 2.32 -2.3466 3.48 -4.84 3.48 c-0.94666 -0.01334 -1.8233 -0.22 -2.63 -0.62 s-1.45 -1.0233 -1.93 -1.87 s-0.72 -1.83 -0.72 -2.95 c0 -1.0533 0.24334 -2.0134 0.73 -2.88 s1.1333 -1.5133 1.94 -1.94 s1.6767 -0.64 2.61 -0.64 z M69.9 13.719999999999999 c-0.13334 -0.77334 -0.38 -1.3333 -0.74 -1.68 s-0.87334 -0.52 -1.54 -0.52 c-0.69334 0 -1.24 0.19666 -1.64 0.59 s-0.63334 0.93 -0.7 1.61 l4.62 0 z M78.66 9.38 c1.3867 0 2.47 0.28002 3.25 0.84002 s1.2167 1.38 1.31 2.46 l-2.7 0 c-0.04 -0.49334 -0.22 -0.85 -0.54 -1.07 s-0.78666 -0.33 -1.4 -0.33 c-0.53334 0 -0.93 0.08 -1.19 0.24 s-0.39 0.4 -0.39 0.72 c0 0.24 0.08666 0.44 0.26 0.6 s0.43668 0.3 0.79002 0.42 s0.74334 0.22 1.17 0.3 c1.2933 0.25334 2.2066 0.51334 2.74 0.78 s0.92334 0.58666 1.17 0.96 s0.37 0.83334 0.37 1.38 c0 1.16 -0.42334 2.05 -1.27 2.67 s-1.9967 0.93 -3.45 0.93 c-1.52 0 -2.7034 -0.32666 -3.55 -0.98 s-1.2833 -1.54 -1.31 -2.66 l2.7 0 c0 0.53334 0.20666 0.95668 0.62 1.27 s0.93334 0.47 1.56 0.47 c0.53334 0 0.97668 -0.11666 1.33 -0.35 s0.53 -0.55668 0.53 -0.97002 c0 -0.26666 -0.11 -0.48666 -0.33 -0.66 s-0.53 -0.32668 -0.93 -0.46002 s-1.02 -0.28668 -1.86 -0.46002 c-0.66666 -0.13334 -1.26 -0.31334 -1.78 -0.54 s-0.91666 -0.52332 -1.19 -0.88998 s-0.41 -0.81666 -0.41 -1.35 c0 -0.68 0.16334 -1.2733 0.49 -1.78 s0.82666 -0.89 1.5 -1.15 s1.51 -0.39 2.51 -0.39 z M88.75999999999999 6.5600000000000005 l0.000019531 3.1 l2.08 0 l0 1.9 l-2.08 0 l0 5.12 c0 0.48 0.08 0.8 0.24 0.96 s0.48 0.24 0.96 0.24 c0.34666 0 0.64 -0.02666 0.88 -0.08 l0 2.22 c-0.4 0.06666 -0.96 0.1 -1.68 0.1 c-1.0933 0 -1.9067 -0.18666 -2.44 -0.56 s-0.8 -1.02 -0.8 -1.94 l0 -6.06 l-1.72 0 l0 -1.9 l1.72 0 l0 -3.1 l2.84 0 z"></path>
                    </g>
                    <g id="SvgjsG3844" featurekey="sloganFeature-0" transform="matrix(1.8645577352966791,0,0,1.8645577352966791,56.426911890089706,68.33473014530277)" fill="#000000">
                        <path d="M8.12 5.720000000000001 c3.0266 0 4.54 1.1733 4.54 3.52 c0 1.3467 -0.64666 2.3466 -1.94 3 c0.88 0.25334 1.5367 0.69668 1.97 1.33 s0.65 1.3967 0.65 2.29 c0 1.28 -0.46334 2.29 -1.39 3.03 s-2.1434 1.11 -3.65 1.11 l-6.92 0 l0 -14.28 l6.74 0 z M7.72 11.5 c1.2667 0 1.9 -0.56666 1.9 -1.7 c0 -1.0933 -0.70666 -1.64 -2.12 -1.64 l-2.98 0 l0 3.34 l3.2 0 z M7.9 17.56 c1.5333 0 2.3 -0.62666 2.3 -1.88 c0 -1.36 -0.74666 -2.04 -2.24 -2.04 l-3.44 0 l0 3.92 l3.38 0 z M23.8955 9.66 l0 5.86 c0 0.8 0.12666 1.42 0.38 1.86 s0.73334 0.66 1.44 0.66 c0.78666 0 1.35 -0.23334 1.69 -0.7 s0.51 -1.2133 0.51 -2.24 l0 -5.44 l2.84 0 l0 10.34 l-2.7 0 l0 -1.44 l-0.06 0 c-0.70666 1.1467 -1.7667 1.72 -3.18 1.72 c-1.3467 0 -2.31 -0.34334 -2.89 -1.03 s-0.87 -1.7433 -0.87 -3.17 l0 -6.42 l2.84 0 z M40.651 9.66 l2.34 7.08 l0.04 0 l2.26 -7.08 l2.94 0 l-4.32 11.64 c-0.30666 0.81334 -0.73 1.4067 -1.27 1.78 s-1.29 0.56 -2.25 0.56 c-0.41334 0 -1.0067 -0.03334 -1.78 -0.1 l0 -2.34 c0.50666 0.06666 1.0067 0.1 1.5 0.1 c0.4 0 0.71 -0.12334 0.93 -0.37 s0.33 -0.55666 0.33 -0.93 c0 -0.21334 -0.04 -0.42668 -0.12 -0.64002 l-3.64 -9.7 l3.04 0 z M73.58200000000001 5.720000000000001 c3.0266 0 4.54 1.1733 4.54 3.52 c0 1.3467 -0.64666 2.3466 -1.94 3 c0.88 0.25334 1.5367 0.69668 1.97 1.33 s0.65 1.3967 0.65 2.29 c0 1.28 -0.46334 2.29 -1.39 3.03 s-2.1434 1.11 -3.65 1.11 l-6.92 0 l0 -14.28 l6.74 0 z M73.182 11.5 c1.2667 0 1.9 -0.56666 1.9 -1.7 c0 -1.0933 -0.70666 -1.64 -2.12 -1.64 l-2.98 0 l0 3.34 l3.2 0 z M73.36200000000001 17.56 c1.5333 0 2.3 -0.62666 2.3 -1.88 c0 -1.36 -0.74666 -2.04 -2.24 -2.04 l-3.44 0 l0 3.92 l3.38 0 z M91.2975 9.38 c0.97334 0 1.84 0.22664 2.6 0.67998 s1.3567 1.11 1.79 1.97 s0.65 1.85 0.65 2.97 c0 0.10666 -0.0066602 0.28 -0.02 0.52 l-7.46 0 c0.02666 0.82666 0.24332 1.47 0.64998 1.93 s1.03 0.69 1.87 0.69 c0.52 0 0.99666 -0.13 1.43 -0.39 s0.71 -0.57666 0.83 -0.95 l2.5 0 c-0.73334 2.32 -2.3466 3.48 -4.84 3.48 c-0.94666 -0.01334 -1.8233 -0.22 -2.63 -0.62 s-1.45 -1.0233 -1.93 -1.87 s-0.72 -1.83 -0.72 -2.95 c0 -1.0533 0.24334 -2.0134 0.73 -2.88 s1.1333 -1.5133 1.94 -1.94 s1.6767 -0.64 2.61 -0.64 z M93.47749999999999 13.719999999999999 c-0.13334 -0.77334 -0.38 -1.3333 -0.74 -1.68 s-0.87334 -0.52 -1.54 -0.52 c-0.69334 0 -1.24 0.19666 -1.64 0.59 s-0.63334 0.93 -0.7 1.61 l4.62 0 z M108.13300000000001 9.38 c1.3867 0 2.47 0.28002 3.25 0.84002 s1.2167 1.38 1.31 2.46 l-2.7 0 c-0.04 -0.49334 -0.22 -0.85 -0.54 -1.07 s-0.78666 -0.33 -1.4 -0.33 c-0.53334 0 -0.93 0.08 -1.19 0.24 s-0.39 0.4 -0.39 0.72 c0 0.24 0.08666 0.44 0.26 0.6 s0.43668 0.3 0.79002 0.42 s0.74334 0.22 1.17 0.3 c1.2933 0.25334 2.2066 0.51334 2.74 0.78 s0.92334 0.58666 1.17 0.96 s0.37 0.83334 0.37 1.38 c0 1.16 -0.42334 2.05 -1.27 2.67 s-1.9967 0.93 -3.45 0.93 c-1.52 0 -2.7034 -0.32666 -3.55 -0.98 s-1.2833 -1.54 -1.31 -2.66 l2.7 0 c0 0.53334 0.20666 0.95668 0.62 1.27 s0.93334 0.47 1.56 0.47 c0.53334 0 0.97668 -0.11666 1.33 -0.35 s0.53 -0.55668 0.53 -0.97002 c0 -0.26666 -0.11 -0.48666 -0.33 -0.66 s-0.53 -0.32668 -0.93 -0.46002 s-1.02 -0.28668 -1.86 -0.46002 c-0.66666 -0.13334 -1.26 -0.31334 -1.78 -0.54 s-0.91666 -0.52332 -1.19 -0.88998 s-0.41 -0.81666 -0.41 -1.35 c0 -0.68 0.16334 -1.2733 0.49 -1.78 s0.82666 -0.89 1.5 -1.15 s1.51 -0.39 2.51 -0.39 z M124.1285 6.5600000000000005 l0.000019531 3.1 l2.08 0 l0 1.9 l-2.08 0 l0 5.12 c0 0.48 0.08 0.8 0.24 0.96 s0.48 0.24 0.96 0.24 c0.34666 0 0.64 -0.02666 0.88 -0.08 l0 2.22 c-0.4 0.06666 -0.96 0.1 -1.68 0.1 c-1.0933 0 -1.9067 -0.18666 -2.44 -0.56 s-0.8 -1.02 -0.8 -1.94 l0 -6.06 l-1.72 0 l0 -1.9 l1.72 0 l0 -3.1 l2.84 0 z"></path>
                    </g>
                </svg>
            </div>
        </div>
        <form action="">
            <div class="border-2 rounded-md">
                <h1 class="border-b-2 p-2 text-2xl font-semibold">User Registration</h1>
                <!-- Profile Picture -->
                <div class="w-full flex flex-col items-center relative mt-3">
                    <img id="previewImage" class="w-16 h-16 rounded-full border object-cover object-center border-black" alt="" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png">
                    <input class="hidden" type="file" id="imageInput">
                    <label for="imageInput" class="absolute bottom-0 translate-y-3 translate-x-[2px] rounded-full bg-white p-1"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <g data-name="Layer 53">
                                    <path d="M22 9.25a.76.76 0 0 0-.75.75v6l-4.18-4.78a2.84 2.84 0 0 0-4.14 0l-2.87 3.28-.94-1.14a2.76 2.76 0 0 0-4.24 0l-2.13 2.57V6A3.26 3.26 0 0 1 6 2.75h8a.75.75 0 0 0 0-1.5H6A4.75 4.75 0 0 0 1.25 6v12a.09.09 0 0 0 0 .05A4.75 4.75 0 0 0 6 22.75h12a4.75 4.75 0 0 0 4.74-4.68V10a.76.76 0 0 0-.74-.75Zm-4 12H6a3.25 3.25 0 0 1-3.23-3L6 14.32a1.29 1.29 0 0 1 1.92 0l1.51 1.82a.74.74 0 0 0 .57.27.86.86 0 0 0 .57-.26l3.44-3.94a1.31 1.31 0 0 1 1.9 0l5.27 6A3.24 3.24 0 0 1 18 21.25Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M4.25 7A2.75 2.75 0 1 0 7 4.25 2.75 2.75 0 0 0 4.25 7Zm4 0A1.25 1.25 0 1 1 7 5.75 1.25 1.25 0 0 1 8.25 7ZM16 5.75h2.25V8a.75.75 0 0 0 1.5 0V5.75H22a.75.75 0 0 0 0-1.5h-2.25V2a.75.75 0 0 0-1.5 0v2.25H16a.75.75 0 0 0 0 1.5Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </g>
                        </svg></label>
                    <script>
                        const imageInput = document.getElementById('imageInput');
                        const previewImage = document.getElementById('previewImage');

                        function previewSelectedImage() {
                            const file = imageInput.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = function(e) {
                                    previewImage.src = e.target.result;
                                }
                            }
                        }
                        imageInput.addEventListener('change', previewSelectedImage);
                    </script>
                </div>
                <div class="grid grid-cols-1 p-5 md:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1 ">
                        <label for="fname" class="require font-semibold">First Name :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="text" name="fname" id="fname">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter first name !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1 ">
                        <label for="name" class="require font-semibold">Last Name :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="text" name="name" id="name">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter last name !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="email" class="require font-semibold">Email :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="email" name="email" id="email">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter email !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1 relative" x-data="{ showPassword: false }">
                        <label for="password" class="require font-semibold">Password :</label>
                        <input class="h-12 rounded-md border-2 pr-10 border-gray-300 hover:border-indigo-500 hover:transition" x-bind:type="showPassword ? 'text' : 'password'" type="password" name="password" id="password">
                        <span class="absolute top-10 right-2.5 cursor-pointer" x-on:click="showPassword = !showPassword"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                <path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path>
                                <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path>
                            </svg></span>
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter password !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label for="username" class="require font-semibold">Address :</label>
                        <textarea class="h-full rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition resize-none" name="address" id="address"></textarea>
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter address !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="username" class="require font-semibold">Mobile No :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="tel" name="mobileno" id="mobileno" maxlength="10">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter mobile number !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="username" class="require font-semibold">State :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="text" name="state" id="state">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter state !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="username" class="require font-semibold">City :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="text" name="city" id="city">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter city !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="username" class="require font-semibold">Pincode :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-indigo-500 hover:transition" type="tel" name="pincode" id="pincode" maxlength="6">
                        <p class="hidden text-sm font-medium translate-x-1 text-red-600">Please enter Pincode !</p>
                        <!-- remove hidden class to show in <p> tag -->
                    </div>
                </div>
                <div class="flex justify-center mb-5">
                    <button class="bg-indigo-500 font-semibold h-10 w-72 text-lg rounded-md text-white hover:bg-indigo-600 hover:transition">Register</button>
                </div>
            </div>
        </form>
        <div class="flex flex-col items-center gap-2 mt-5">
            <a class="underline font-semibold" href="../vendor_auth/vendor_register.php">Become a Vendor</a>
            <a class="underline font-semibold" href="user_login.php">Already a member? Login</a>
        </div>
    </div>
</body>

</html>