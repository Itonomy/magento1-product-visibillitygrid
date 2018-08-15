# Magento 1 Product Visibility Grid

**Did you every wonder why your product is not showing up in a category in Magento?**

Magento has a complex way of building a product collection. Due to several conditions, indexes, plugins and other complexity, determining whether a product should show is not that straightforward. 

This grid is making your life easier. It shows the different "visibility conditions" in columns and whether a product is or isn't showing up in your category (collection).
<img align="center" src="https://i.imgur.com/jcAVpde.png" height="200">
* Determine whether a product is showing in category (yes/no)
* Columns per index/condition
* Reindex per product
* Mass reindex selection

 <strong>Table of Contents</strong>
* [Magento 2 Version](https://github.com/Itonomy/magento2-product-visibillitygrid)
* [Requirements](#-requirements)
* [Installation](#-installation)
* [Usage](#️-usage)
* [Version](#️-version)
* [Special Thanks](#️-special-thanks)
* [License](https://github.com/Itonomy/magento1-product-visibillitygrid/blob/master/LICENSE)

# Requirements

- Magento 1
  - Tested on:
    - Community: 1.8.X, 1.9.X
    - Enterprise: 1.14.X
- PHP: >5.6

# Installation

#### Via [modman](https://github.com/colinmollenhour/modman)
1. Install Modman according to their documents
2. `modman init` in the magento root.
3. `modman clone git@github.com:Itonomy/magento1-product-visibillitygrid.git`
4. Cache clear and the module should be available!

#### Via download
1. Download the zip [here](https://github.com/Itonomy/magento1-product-visibillitygrid/archive/master.zip)
2. Extract in your magento root.
3. Cache clear and the module should be available!

# Usage

In the menu on Admin:

<img align="center" src="https://i.imgur.com/Ag2atIi.png" height="200">


Feel free to contribute or report issues in the issues list for this repository.

# Version

- Updated to version 1.0.0 to achieve a first version

## Special Thanks

* Jerrol Etheredge for creating the basis of this module.
