@extends('layouts.app')

@section('title', 'Products - Art & Culture Popayán')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="{{ asset('css/pages/products-index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="products-page">
    <!-- Header -->
    <section class="products-header">
        <div class="container">
            <h1><i class="fas fa-shopping-bag"></i> Products & Crafts</h1>
            <p>Discover unique works from artists and artisans of Popayán</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-grid">
                <!-- Search -->
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search products...">
                </div>

                <!-- Category Filter -->
                <div class="filter-group">
                    <label for="categoryFilter"><i class="fas fa-tags"></i> Category</label>
                    <select id="categoryFilter">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="filter-group">
                    <label for="typeFilter"><i class="fas fa-box"></i> Type</label>
                    <select id="typeFilter">
                        <option value="">All types</option>
                        <option value="physical">Physical</option>
                        <option value="digital">Digital</option>
                        <option value="service">Service</option>
                        <option value="handicraft">Craft</option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="filter-group">
                    <label for="sortFilter"><i class="fas fa-sort"></i> Sort by</label>
                    <select id="sortFilter">
                        <option value="newest">Newest</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="products-main">
        <div class="container">
            <!-- Statistics -->
            <div class="products-stats">
                <div class="stat-card">
                    <i class="fas fa-box-open"></i>
                    <span class="stat-number">{{ $products->total() }}</span>
                    <span class="stat-label">Available Products</span>
                </div>
                <div class="stat-card">
                    <i class="fas fa-palette"></i>
                    <span class="stat-number">{{ $categories->count() }}</span>
                    <span class="stat-label">Categories</span>
                </div>
                <div class="stat-card">
                    <i class="fas fa-store"></i>
                    <span class="stat-number" id="totalArtists">0</span>
                    <span class="stat-label">Artists</span>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                @forelse($products as $product)
                    <div class="product-card" 
                         data-category="{{ $product->category_id }}"
                         data-type="{{ $product->product_type }}"
                         data-price="{{ $product->price }}"
                         data-title="{{ strtolower($product->name) }}"
                         data-sales="{{ $product->sales_count }}">
                        <!-- Product Image -->
                        <div class="product-image">
                            @if($product->main_image)
                                <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}">
                            @elseif($product->images->isNotEmpty())
                                <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <div class="product-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="product-badges">
                                <span class="badge type-{{ $product->product_type }}">
                                    {{ $product->product_type === 'physical' ? 'Physical' : 
                                       ($product->product_type === 'digital' ? 'Digital' : 
                                       ($product->product_type === 'service' ? 'Service' : 'Craft')) }}
                                </span>
                                @if($product->is_featured)
                                    <span class="badge featured">
                                        <i class="fas fa-star"></i> Featured
                                    </span>
                                @endif
                            </div>

                            <!-- Quick actions -->
                            <div class="product-actions">
                                <button class="action-btn wishlist" data-product-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn view" onclick="window.location='{{ route('products.show', $product->id) }}'">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            
                            <div class="product-meta">
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $product->user->name }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $product->category->name ?? 'No category' }}</span>
                                </div>
                            </div>

                            <div class="product-pricing">
                                @if($product->sale_price)
                                    <div class="price-original">${{ number_format($product->price, 0) }}</div>
                                    <div class="price-sale">${{ number_format($product->sale_price, 0) }}</div>
                                @else
                                    <div class="price-normal">${{ number_format($product->price, 0) }}</div>
                                @endif
                            </div>

                            <div class="product-stats">
                                <span class="stat">
                                    <i class="fas fa-shopping-cart"></i> {{ $product->sales_count }} sold
                                </span>
                                <span class="stat">
                                    <i class="fas fa-box"></i> 
                                    @if($product->product_type === 'digital')
                                        Digital
                                    @else
                                        {{ $product->stock_quantity }} in stock
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Main actions -->
                        <div class="product-main-actions">
                            <button class="btn-primary add-to-cart" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-products">
                        <i class="fas fa-box-open"></i>
                        <h3>No products available</h3>
                        <p>New artisanal products in Popayán coming soon</p>
                        @auth
                            <a href="{{ route('products.create') }}" class="btn-primary">
                                <i class="fas fa-plus"></i> Create First Product
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/modules-products-index.js') }}"></script>
@endsection