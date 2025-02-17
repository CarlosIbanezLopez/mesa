// Usage: https://www.chartjs.org/
import { Chart, registerables } from 'chart.js';

// Registrar los componentes necesarios de Chart.js
Chart.register(...registerables);

// Configuración global de Chart.js
Chart.defaults.responsive = true;
Chart.defaults.maintainAspectRatio = false;
Chart.defaults.plugins.legend.position = 'top';
Chart.defaults.plugins.title.display = true;
Chart.defaults.plugins.title.font = {
    size: 16,
    weight: 'bold'
};

// Colores personalizados
const colors = {
    primary: '#4361ee',
    success: '#2ec4b6',
    info: '#3f8cff',
    warning: '#ffc107',
    danger: '#fc5185'
};

// Configuración para gráficos de barras
Chart.defaults.bar = {
    backgroundColor: colors.primary,
    borderColor: colors.primary,
    borderWidth: 1
};

// Configuración para gráficos de línea
Chart.defaults.line = {
    borderColor: colors.success,
    backgroundColor: 'rgba(46, 196, 182, 0.1)',
    tension: 0.4,
    fill: true
};

window.Chart = Chart;
