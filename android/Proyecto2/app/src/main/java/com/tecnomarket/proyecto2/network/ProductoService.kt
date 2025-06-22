package com.tecnomarket.proyecto2.network

import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext
import org.json.JSONArray
import java.net.HttpURLConnection
import java.net.URL

suspend fun obtenerProductosPorCategoria(categoriaId: Int): List<Producto> {
    return withContext(Dispatchers.IO) {
        val productos = mutableListOf<Producto>()
        val url = URL("http://10.0.2.2/ds6-proyecto2/android/functions/productos_categoria.php?id=$categoriaId")

        val connection = url.openConnection() as HttpURLConnection
        connection.requestMethod = "GET"

        try {
            println("Conectando a ${url}")

            if (connection.responseCode == HttpURLConnection.HTTP_OK) {
                val response = connection.inputStream.bufferedReader().readText()
                println("Respuesta JSON: $response")

                try {
                    val jsonArray = JSONArray(response)
                    for (i in 0 until jsonArray.length()) {
                        val item = jsonArray.getJSONObject(i)
                        productos.add(
                            Producto(
                                id = item.getInt("id"),
                                nombre = item.getString("nombre"),
                                precio = item.getDouble("precio"),
                                imagen = item.getString("imagen")
                            )
                        )
                    }
                } catch (jsonException: Exception) {
                    println("Error al parsear JSON: ${jsonException.message}")
                }
            } else {
                val errorStream = connection.errorStream?.bufferedReader()?.readText()
                println("Error HTTP: ${connection.responseCode}, detalle: $errorStream")
            }
        } catch (e: Exception) {
            println("Excepción al conectar: ${e.message}")
        } finally {
            connection.disconnect()
        }

        productos
    }
}

