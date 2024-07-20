<div class="products-filter-wrap">
    <div class="text-center filter-wrap title">
        <h3>Filters</h3>
        <a href="javascript:void(0)" @click="$dispatch('resetfields')">clear all</a>
    </div>
    <div class="products-filters">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Aisle
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                    <div class="accordion-body">
                        <ul>
                            @foreach ($categories as $category)
                                <li>
                                    <div class="form-checkbox filter-checkbox">
                                        <input type="checkbox" value="{{ $category->id }}" id="v{{ $category->id }}" name="categoryId" x-model="categoryId" />
                                        <label for="v{{ $category->id }}"><span>{{ $category->name }}</span></label>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Dietary Restrictions
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                    <div class="accordion-body">
                        <ul>
                            @foreach ($dietaryRestrictions as $dietaryRestriction)
                                <li>
                                    <div class="form-checkbox filter-checkbox">
                                        <input type="checkbox" value="{{ $dietaryRestriction->id }}" id="dietaryId{{ $dietaryRestriction->id }}" name="dietaryRestrictionId" x-model="dietaryRestrictionId" />
                                        <label for="dietaryId{{ $dietaryRestriction->id }}"><span>{{ $dietaryRestriction->name }}</span></label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.layouts.livewire.loading')
