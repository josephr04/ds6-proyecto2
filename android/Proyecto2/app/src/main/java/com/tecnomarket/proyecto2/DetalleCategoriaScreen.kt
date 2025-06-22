package com.tecnomarket.proyecto2

import androidx.activity.compose.LocalOnBackPressedDispatcherOwner
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.input.TextFieldValue
import androidx.compose.ui.unit.dp
import com.tecnomarket.proyecto2.network.Producto
import com.tecnomarket.proyecto2.network.obtenerProductosPorCategoria
import com.tecnomarket.proyecto2.ui.ProductoCard

@Composable
fun DetalleCategoriaScreen(nombreCategoria: String, categoriaId: Int) {
    var productosOriginales by remember { mutableStateOf<List<Producto>>(emptyList()) }
    var productosFiltrados by remember { mutableStateOf<List<Producto>>(emptyList()) }
    var cargando by remember { mutableStateOf(true) }
    var error by remember { mutableStateOf<String?>(null) }
    var ordenAscendente by remember { mutableStateOf(true) }
    var expanded by remember { mutableStateOf(false) }
    var searchText by remember { mutableStateOf(TextFieldValue("")) }

    val baseUrl = "http://10.0.2.2/ds6-proyecto2/imagenes/productos/"
    val backDispatcher = LocalOnBackPressedDispatcherOwner.current?.onBackPressedDispatcher

    LaunchedEffect(categoriaId) {
        try {
            cargando = true
            val listaOriginal = obtenerProductosPorCategoria(categoriaId)
            productosOriginales = listaOriginal.map {
                it.copy(imagen = baseUrl + it.imagen)
            }
        } catch (e: Exception) {
            error = "Error: ${e.message}"
        } finally {
            cargando = false
        }
    }

    LaunchedEffect(searchText, ordenAscendente, productosOriginales) {
        if (productosOriginales.isNotEmpty()) {
            val filtrados = productosOriginales.filter {
                it.nombre.contains(searchText.text, ignoreCase = true)
            }
            productosFiltrados = if (ordenAscendente) {
                filtrados.sortedBy { it.precio }
            } else {
                filtrados.sortedByDescending { it.precio }
            }
        }
    }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .padding(16.dp)
    ) {
        // Botón de retroceso + Título
        Row(
            verticalAlignment = Alignment.CenterVertically,
            modifier = Modifier
                .fillMaxWidth()
                .padding(bottom = 8.dp)
        ) {
            IconButton(onClick = { backDispatcher?.onBackPressed() }) {
                Icon(
                    imageVector = Icons.Default.ArrowBack,
                    contentDescription = "Atrás"
                )
            }
            Spacer(modifier = Modifier.width(8.dp))
            Text(
                text = "$nombreCategoria",
                style = MaterialTheme.typography.headlineMedium
            )
        }

        // Campo de búsqueda moderno
        OutlinedTextField(
            value = searchText,
            onValueChange = { searchText = it },
            label = { Text("Buscar productos") },
            modifier = Modifier
                .fillMaxWidth()
                .padding(vertical = 8.dp),
            singleLine = true,
            shape = RoundedCornerShape(50)
        )

        // Botón de ordenamiento
        Box(
            modifier = Modifier
                .fillMaxWidth()
                .wrapContentSize(Alignment.TopStart)
        ) {
            Button(onClick = { expanded = true }) {
                Text(if (ordenAscendente) "Precio: Menor a mayor" else "Precio: Mayor a menor")
            }

            DropdownMenu(
                expanded = expanded,
                onDismissRequest = { expanded = false }
            ) {
                DropdownMenuItem(
                    text = { Text("Menor a mayor") },
                    onClick = {
                        ordenAscendente = true
                        expanded = false
                    }
                )
                DropdownMenuItem(
                    text = { Text("Mayor a menor") },
                    onClick = {
                        ordenAscendente = false
                        expanded = false
                    }
                )
            }
        }

        Spacer(modifier = Modifier.height(16.dp))

        when {
            cargando -> Box(
                modifier = Modifier.fillMaxSize(),
                contentAlignment = Alignment.Center
            ) {
                CircularProgressIndicator()
            }

            error != null -> Text(error ?: "Error desconocido")

            productosOriginales.isNotEmpty() && productosFiltrados.isEmpty() -> Text("No se encontraron productos.")

            productosFiltrados.isNotEmpty() -> LazyVerticalGrid(
                columns = GridCells.Fixed(2),
                verticalArrangement = Arrangement.spacedBy(16.dp),
                horizontalArrangement = Arrangement.spacedBy(16.dp),
                modifier = Modifier.fillMaxSize(),
                contentPadding = PaddingValues(bottom = 100.dp)
            ) {
                items(productosFiltrados) { producto ->
                    ProductoCard(producto.nombre, producto.imagen, producto.precio)
                }
            }
        }
    }
}
