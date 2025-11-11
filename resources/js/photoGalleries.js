import lightGallery from "lightgallery";
import lgZoom from "lightgallery/plugins/zoom";
import lgThumbnail from "lightgallery/plugins/thumbnail";
import "lightgallery/css/lightgallery.css";
import "lightgallery/css/lg-zoom.css";
import "lightgallery/css/lg-thumbnail.css";

const photoGallery = document.querySelector(".photo-galleries .container");
if (photoGallery) {
    lightGallery(photoGallery, {
        selector: "a.gallery3-item",
        plugins: [lgZoom, lgThumbnail],
        speed: 500,
        licenseKey: "GPLv3",
    });
}
