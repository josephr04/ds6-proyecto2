package com.tecnomarket.proyecto2.model

import kotlinx.serialization.Serializable

@Serializable
data class Categoria(
    val id: Int,
    val nombre: String
)
