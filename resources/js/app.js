import "./bootstrap";
import * as bootstrap from "bootstrap";
import "../css/app.css";

// Делаем Bootstrap глобально доступным
window.bootstrap = bootstrap;

import Swal from "sweetalert2";
window.Swal = Swal; // чтобы SweetAlert был доступен глобально
