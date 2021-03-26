<div class="data-view-selection-menu-container">
    <div class="data-view-selection-menu__content">
        <h4 class="data-view-selection-menu__title">Select a data view
            <button class="data-view-selection-menu__close">Close</button>
        </h4>
        <ul class="data-view-selection-menu">
            <li>
                <a href="/data-view?ship=<?php echo $_GET['ship']; ?>&data-view=fixed-age-value"
                   class="data-view-selector"
                   data-view-to-load="fixed-age-value">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon-line-graph-filled-white.svg" alt=""
                         class="data-view-selection-menu__icon"> Fixed Age Value
                </a>
            </li>
            <li>
                <a href="/data-view?ship=<?php echo $_GET['ship']; ?>&data-view=depreciation"
                   class="data-view-selector"
                   data-view-to-load="depreciation">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon-descending-bars-filled-white.svg"
                         alt="" class="data-view-selection-menu__icon"> Depreciation
                </a>
            </li>
        </ul>
    </div>
</div>