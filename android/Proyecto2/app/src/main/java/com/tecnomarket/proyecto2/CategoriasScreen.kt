package com.tecnomarket.proyecto2

import androidx.compose.foundation.layout.*
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.navigation.NavHostController
import com.tecnomarket.proyecto2.network.Categoria
import com.tecnomarket.proyecto2.network.obtenerCategorias
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

@Composable
fun CategoriasScreen(navController: NavHostController) {
    var categorias by remember { mutableStateOf<List<Categoria>>(emptyList()) }
    var cargando by remember { mutableStateOf(true) }
    var error by remember { mutableStateOf<String?>(null) }

    LaunchedEffect(Unit) {
        try {
            cargando = true
            val resultado = withContext(Dispatchers.IO) { obtenerCategorias() }
            categorias = resultado
        } catch (e: Exception) {
            error = "Error al cargar categorías: ${e.message}"
        } finally {
            cargando = false
        }
    }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .padding(24.dp),
        verticalArrangement = Arrangement.Top
    ) {
        // Fila con botón de retroceso y título
        Row(
            verticalAlignment = Alignment.CenterVertically,
            modifier = Modifier.fillMaxWidth()
        ) {
            Box(modifier = Modifier.offset(y = (0).dp)) {
                IconButton(onClick = { navController.popBackStack() }) {
                    Icon(
                        imageVector = Icons.Default.ArrowBack,
                        contentDescription = "Atrás"
                    )
                }
            }
            Spacer(modifier = Modifier.width(8.dp))
            Text(
                "Categorías",
                style = MaterialTheme.typography.headlineMedium
            )
        }

        when {
            cargando -> {
                CircularProgressIndicator()
            }
            error != null -> {
                Text(text = error ?: "Error desconocido", color = MaterialTheme.colorScheme.error)
            }
            else -> {
                categorias.forEach { categoria ->
                    Button(
                        onClick = {
                            val nombreEscapado = java.net.URLEncoder.encode(categoria.nombre, "UTF-8")
                            navController.navigate("detalle_categoria/$nombreEscapado/${categoria.id}")
                        },
                        modifier = Modifier
                            .fillMaxWidth()
                            .padding(vertical = 8.dp)
                    ) {
                        Text(categoria.nombre)
                    }
                }
            }
        }
    }
}
