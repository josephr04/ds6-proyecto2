package com.tecnomarket.proyecto2.network

import io.ktor.client.*
import io.ktor.client.call.*
import io.ktor.client.engine.cio.*
import io.ktor.client.plugins.contentnegotiation.*
import io.ktor.client.request.*
import io.ktor.serialization.kotlinx.json.*
import kotlinx.serialization.Serializable
import kotlinx.serialization.json.Json

@Serializable
data class Categoria(
    val id: Int,
    val nombre: String
)

suspend fun obtenerCategorias(): List<Categoria> {
    val client = HttpClient(CIO) {
        install(ContentNegotiation) {
            json(Json {
                ignoreUnknownKeys = true
                explicitNulls = false
            })
        }
    }

    return client.use {
        it.get("http://10.0.2.2/ds6-proyecto2/android/functions/get_categorias.php")
            .body()
    }
}
